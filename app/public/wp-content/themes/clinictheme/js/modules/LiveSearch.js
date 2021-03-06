import $ from 'jquery';

class LiveSearch {

    // ----- Constructor ----- ----- -----
    constructor(){
        this.addSearchHTML(); // Add search HTML to body of page.

        // Setting variables
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsDiv = $("#search-overlay__results")
        
        this.isOverlayOpen = false;
        this.isLoadingVisible = false;
        this.delayedLiveSearch;
        this.previousValue;
        this.events();

        // Settings
        this.delayMilliseconds = 1000; // Delay in typing before sending search request
    }

    // =================================================================
    //                       Events
    // =================================================================

    events(){
        // On mouse click events
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));

        // hook keyboard handlers
        $(document).on("keydown", this.keyPressHandler.bind(this));
        this.searchField.on("keyup", this.liveSearcher.bind(this));
    }

    // =================================================================
    //                       Functions
    // =================================================================

    /** Opens Overlay and sets focus to search field
     * 301ms timeout because of fade effect(300ms)
     * locks scrolling, clears searchfield of text and flags isOverlayOpen TRUE
     * 
     * Adds CSS classes to provide functionality
     */
    openOverlay(){
        if(!this.isOverlayOpen){
            this.searchOverlay.addClass("search-overlay--active")
            $("body").addClass("body-no-scroll");
            this.searchField.val('');
            setTimeout( () => this.searchField.focus(), 301 );
            this.isOverlayOpen = true;
            return false; // magic oneliner to prevent <a href="link">(our non-JS fallback search) from firing if user has JS enabled.
        }
    }

    /**
     * Closes overlay by removing CSS classes and changes isOverlayOpen flag to FALSE
     */
    closeOverlay(){
        if(this.isOverlayOpen){
            this.searchOverlay.removeClass("search-overlay--active")
            $("body").removeClass("body-no-scroll");
            this.isOverlayOpen = false;
        }
    }

    /**
     * Handler for keyboard shortcuts
     * @param {KeyboardEvent} e 
     */
    keyPressHandler(e){
        if(e.key === "Escape") { // Escape pressed - close overlay
            this.closeOverlay();
        }
        // "s" key pressed - open overlay | ignore on already open overlay OR if other input/textfield has focus
        if(e.keyCode == 83 && !$("input, textarea").is(':focus')) { 
            this.openOverlay();
        }
    }

    /**
     * Live Search Function
     * searches in real-time as you type, but after a pause in typing.
     * Change delay before search request is sent in Constructor.
     * 
     * Conditional checks for new vs old string in search term, to prevent all keyboard events from firing search request.
     * Conditional checks for when to display Spinning Loading Icon
     * 
     * Calls getResults() with the search-term string provided by user.
     */
    liveSearcher(){
        if(this.searchField.val() != this.previousValue) {
            clearTimeout(this.delayedLiveSearch);

            if(this.searchField.val()) {
                if(!this.isLoadingVisible){
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                    this.isLoadingVisible = true;
                }          
                this.delayedLiveSearch = setTimeout(this.getResults.bind(this), this.delayMilliseconds);    
            } else {
                this.resultsDiv.html('');
                this.isLoadingVisible = false;
            }
        }
        this.previousValue = this.searchField.val();
    }
    /** Get Results - gets JSON data for liveSearcer()
     * 
     * Recieves search-term from liveSearcher() function.
     * fetches JSON data for all post types matching search and displays them in results.
     */
    getResults(){ 
        $.getJSON(clinic_data.root_url + '/wp-json/clinic/v1/search?term=' + this.searchField.val(), (results) => {
            this.resultsDiv.html(`
              <div class="row">
                <div class="one-third">
                  <h2 class="search-overlay__section-title">Articles</h2>
                  ${results.articles.length ? '<ul class="link-list min-list">' : `No articles match your search, <a href="${clinic_data.root_url}/articles">View all articles</a>`}
                  ${results.articles.map(item => `<li><a href="${item.link}">${item.title}</a> ${item.post_type == 'post' ? `by ${item.author_name}` : ``}</li>`).join('')}
                  ${results.articles.length ? '</ul>' : ''}
                  
                  <h2 class="search-overlay__section-title">Pages</h2>
                  ${results.pages.length ? '<ul class="link-list min-list">' : 'No matching pages'}
                  ${results.pages.map(item => `<li><a href="${item.link}">${item.title}</a></li>`).join('')}
                  ${results.pages.length ? '</ul>' : ''}
                </div>

                <div class="one-third">
                  <h2 class="search-overlay__section-title">Locales</h2>
                  ${results.locales.length ? '<ul class="link-list min-list">' : `No matches, <a href="${clinic_data.root_url}/locales">View all locales</a>`}
                  ${results.locales.map(item => `<li><a href="${item.link}">${item.title}</a></li>`).join('')}
                  ${results.locales.length ? '</ul>' : ''}

                  <h2 class="search-overlay__section-title">Employees</h2>
                  ${results.employees.length ? '<ul class="employee-cards">' : `No matches, <a href="${clinic_data.root_url}/about-us/our-staff">View all employees</a>`}
                  ${results.employees.map(item => `
                    <li class="employee-card__list-item">
                      <a class="employee-card" href="${item.link}">
                        <img class="employee-card__image" src="${item.img}">
                        <span class="employee-card__name">${item.title}</span>
                      </a>
                    </li>
                  `).join('')}
                  ${results.employees.length ? '</ul>' : ''}
                </div>

                <div class="one-third">
                  <h2 class="search-overlay__section-title">Events</h2>
                  ${results.events.length ? '' : `No matches, <a href="${clinic_data.root_url}/events">View all events</a>`}
                  ${results.events.map(item => `
                    <div class="event-summary">
                        <a class="event-summary__date t-center" href="${item.link}">
                        <span class="event-summary__month">${item.month}</span>
                        <span class="event-summary__day">${item.day}</span></a>
                        <div class="event-summary__content">
                            <h5 class="event-summary__title headline headline--tiny"><a href="${item.link}">
                            ${item.title}</a></h5>
                            <p><a href="${item.link}" class="nu c-blue"></a></p>
                        </div>
                    </div>                  
                  `).join('')}
                  ${results.events.length ? '</ul>' : ''}

                  <h2 class="search-overlay__section-title">Treatments</h2>
                  ${results.treatments.length ? '<ul class="link-list min-list">' : 'No matches'}
                  ${results.treatments.map(item => `<li><a href="${item.link}">${item.title}</a></li>`).join('')}
                  ${results.treatments.length ? '</ul>' : ''}
                </div>
              </div>
            `);
            this.isLoadingVisible = false;
        });
    }

    addSearchHTML(){
        $("body").append(`
          <div class="search-overlay">
            <div class="search-overlay__top">
              <div class ="container">
                <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                <input type="text" class="search-term" placeholder="search" id="search-term">
                <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
              </div>
            </div>

            <div class="container">
              <div id=search-overlay__results>
                <script></script>
              </div>
            </div>
          </div>
        `)
    }



}

export default LiveSearch;