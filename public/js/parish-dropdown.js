/**
 * Parish Dropdown with Search and Pagination
 * Handles the searchable parish dropdown on the index page
 */

class ParishDropdown {
    constructor() {
        this.currentPage = 1;
        this.searchTerm = '';
        this.selectedParish = null;
        this.totalPages = 1;
        this.totalParishes = 0;
        this.isLoading = false;
        this.debounceTimer = null;
        
        this.init();
    }

    init() {
        this.parishSearch = document.getElementById('parish-search');
        this.parishSelect = document.getElementById('parish-select');
        this.parishDropdown = document.getElementById('parish-dropdown');
        this.parishOptions = document.getElementById('parish-options');
        this.parishPagination = document.getElementById('parish-pagination');

        if (!this.parishSearch || !this.parishDropdown) {
            console.error('Parish dropdown elements not found');
            return;
        }

        this.setupEventListeners();
        this.loadInitialParishes();
    }

    setupEventListeners() {
        // Search input events
        this.parishSearch.addEventListener('input', (e) => {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.searchTerm = e.target.value;
                this.currentPage = 1;
                this.loadParishes();
            }, 300);
        });

        this.parishSearch.addEventListener('focus', () => {
            this.showDropdown();
        });

        // Keyboard navigation
        this.parishSearch.addEventListener('keydown', (e) => {
            this.handleKeyboardNavigation(e);
        });

        // Click outside to close
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.parish-dropdown-wrapper')) {
                this.hideDropdown();
            }
        });

        // Prevent dropdown from closing when clicking inside
        this.parishDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }

    async loadInitialParishes() {
        this.currentPage = 1;
        this.searchTerm = '';
        await this.loadParishes();
    }

    async loadParishes() {
        if (this.isLoading) return;

        this.isLoading = true;
        this.showLoading();

        try {
            const params = new URLSearchParams({
                page: this.currentPage,
                search: this.searchTerm
            });

            const response = await fetch(`/api/parishes?${params}`);
            const data = await response.json();

            if (response.ok) {
                this.renderParishes(data.data);
                this.renderPagination(data);
                this.totalPages = data.last_page;
                this.totalParishes = data.total;
            } else {
                console.error('Error loading parishes:', data);
                this.showError('Failed to load parishes');
            }
        } catch (error) {
            console.error('Network error:', error);
            this.showError('Network error. Please try again.');
        } finally {
            this.isLoading = false;
        }
    }

    renderParishes(parishes) {
        if (parishes.length === 0) {
            this.parishOptions.innerHTML = '<div class="no-parishes">No parishes found</div>';
            return;
        }

        const html = parishes.map(parish => `
            <div class="parish-option ${this.selectedParish?.value === parish.value ? 'selected' : ''}" 
                 data-parish-value="${parish.value}"
                 data-parish-name="${parish.name}">
                <div class="parish-option-name">${parish.name}</div>
                ${parish.address ? `<div class="parish-option-address">${parish.address}</div>` : ''}
            </div>
        `).join('');

        this.parishOptions.innerHTML = html;

        // Add click listeners to parish options
        this.parishOptions.querySelectorAll('.parish-option').forEach(option => {
            option.addEventListener('click', () => {
                this.selectParish(option);
            });
        });
    }

    renderPagination(data) {
        if (data.total <= data.per_page) {
            this.parishPagination.innerHTML = '';
            return;
        }

        const startItem = (data.current_page - 1) * data.per_page + 1;
        const endItem = Math.min(data.current_page * data.per_page, data.total);

        const html = `
            <div class="parish-pagination-info">
                Showing ${startItem}-${endItem} of ${data.total} parishes
            </div>
            <div class="parish-pagination-controls">
                <button class="parish-pagination-btn" 
                        onclick="window.parishDropdown.goToPage(${data.current_page - 1})"
                        ${data.current_page <= 1 ? 'disabled' : ''}>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span style="font-size: 12px; color: #374151; padding: 4px 8px;">
                    ${data.current_page} / ${data.last_page}
                </span>
                <button class="parish-pagination-btn" 
                        onclick="window.parishDropdown.goToPage(${data.current_page + 1})"
                        ${!data.has_more_pages ? 'disabled' : ''}>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        `;

        this.parishPagination.innerHTML = html;
    }

    selectParish(optionElement) {
        // Remove previous selection
        this.parishOptions.querySelectorAll('.parish-option').forEach(opt => {
            opt.classList.remove('selected');
        });

        // Add selection to clicked option
        optionElement.classList.add('selected');

        // Update form values
        const parishValue = optionElement.dataset.parishValue;
        const parishName = optionElement.dataset.parishName;
        
        this.selectedParish = {
            value: parishValue,
            name: parishName
        };

        this.parishSelect.value = parishValue;
        this.parishSearch.value = parishName;

        // Hide dropdown
        this.hideDropdown();

        // Trigger change event for calendar compatibility
        this.parishSelect.dispatchEvent(new Event('change'));

        // Add visual feedback
        this.parishSearch.style.borderColor = '#10b981';
        setTimeout(() => {
            this.parishSearch.style.borderColor = '';
        }, 1000);
    }

    goToPage(page) {
        if (page < 1 || page > this.totalPages || this.isLoading) return;
        
        this.currentPage = page;
        this.loadParishes();
    }

    handleKeyboardNavigation(e) {
        const visibleOptions = Array.from(this.parishOptions.querySelectorAll('.parish-option'))
            .filter(option => option.style.display !== 'none');
        
        const currentIndex = visibleOptions.findIndex(option => 
            option.classList.contains('selected')
        );

        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                if (currentIndex < visibleOptions.length - 1) {
                    this.highlightOption(visibleOptions[currentIndex + 1]);
                } else if (visibleOptions.length > 0) {
                    this.highlightOption(visibleOptions[0]);
                }
                break;
            case 'ArrowUp':
                e.preventDefault();
                if (currentIndex > 0) {
                    this.highlightOption(visibleOptions[currentIndex - 1]);
                } else if (visibleOptions.length > 0) {
                    this.highlightOption(visibleOptions[visibleOptions.length - 1]);
                }
                break;
            case 'Enter':
                e.preventDefault();
                if (currentIndex >= 0) {
                    this.selectParish(visibleOptions[currentIndex]);
                }
                break;
            case 'Escape':
                this.hideDropdown();
                break;
        }
    }

    highlightOption(option) {
        // Remove previous highlight
        this.parishOptions.querySelectorAll('.parish-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        
        // Add highlight to new option
        option.classList.add('selected');
        
        // Scroll into view if needed
        option.scrollIntoView({ block: 'nearest' });
    }

    showDropdown() {
        this.parishDropdown.classList.remove('hidden');
    }

    hideDropdown() {
        this.parishDropdown.classList.add('hidden');
    }

    showLoading() {
        this.parishOptions.innerHTML = '<div class="loading-parishes">Loading parishes...</div>';
    }

    showError(message) {
        this.parishOptions.innerHTML = `<div class="no-parishes">${message}</div>`;
    }

    // Public method to get selected parish (for calendar integration)
    getSelectedParish() {
        return this.selectedParish;
    }

    // Public method to set parish programmatically
    setParish(parishValue, parishName) {
        this.selectedParish = { value: parishValue, name: parishName };
        this.parishSelect.value = parishValue;
        this.parishSearch.value = parishName;
    }
}

// Initialize the parish dropdown when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.parishDropdown = new ParishDropdown();
});
