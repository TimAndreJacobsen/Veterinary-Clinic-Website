import $ from 'jquery';

class LiveSearch {
    // Constructor
    constructor(){
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsDiv = $("#search-overlay__results")
        this.delayedLiveSearch;
        this.previousValue;
        this.delayMilliseconds = 2000; // 1000ms = 1second
        this.events();
        this.isOverlayOpen = false;
        this.isLoadingVisible = false;
    }

    // Events
    events(){
        // On mouse click events
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));

        // hook keyboard handlers
        $(document).on("keydown", this.keyPressHandler.bind(this));
        this.searchField.on("keyup", this.liveSearcher.bind(this));
    }

    // Functions/Methods

    openOverlay(){
        if(!this.isOverlayOpen){
            this.searchOverlay.addClass("search-overlay--active")
            $("body").addClass("body-no-scroll");
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
        $.getJSON('http://localhost:3000/wp-json/wp/v2/posts?search=' + this.searchField.val(), posts => {
            this.resultsDiv.html(`
            <h2 class="search-overlay__section-title">Search Result</h2>
            <ul class="link-list min-list">
            ${posts.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
            </ul>
          `);
        });
        //this.isLoadingVisible = false;
    }

}

export default LiveSearch;