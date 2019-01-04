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

    // ----- Events ----- ----- ----- -----

    events(){
        // On mouse click events
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));

        // hook keyboard handlers
        $(document).on("keydown", this.keyPressHandler.bind(this));
        this.searchField.on("keyup", this.liveSearcher.bind(this));
    }

    // ----- Functions/Methods ----- ----- ----- -----

    openOverlay(){
        if(!this.isOverlayOpen){
            this.searchOverlay.addClass("search-overlay--active")
            $("body").addClass("body-no-scroll");
            this.searchField.val('');
            setTimeout( () => this.searchField.focus(), 301 );
            this.isOverlayOpen = true;
        }
    }

    closeOverlay(){
        if(this.isOverlayOpen){
            this.searchOverlay.removeClass("search-overlay--active")
            $("body").removeClass("body-no-scroll");
            this.isOverlayOpen = false;
        }
    }

    keyPressHandler(e){
        if(e.key === "Escape") { // Escape pressed - close overlay
            this.closeOverlay();
        }
        // "s" key pressed - open overlay | ignore on open overlay or if input/textfield has focus
        if(e.keyCode == 83 && !$("input, textarea").is(':focus')) { 
            this.openOverlay();
        }
    }

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

    getResults(){
        $.when(
            $.getJSON(clinic_data.root_url + '/wp-json/wp/v2as/posts?search=' + this.searchField.val()),
            $.getJSON(clinic_data.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
            ).then( (posts, pages)=> {
            var result = posts[0].concat(pages[0]);
                this.resultsDiv.html(`
                <h2 class="search-overlay__section-title">Search Result</h2>
                ${result.length ? '<ul class="link-list min-list">' : '<p>No results matches the search</p>'}
                ${result.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                ${result.length ? '</ul>' : ''}
            `);
            this.isLoadingVisible = false;
        }, () => {
            this.resultsDiv.html('<p>Unexpected Error, please try again.</p>');
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