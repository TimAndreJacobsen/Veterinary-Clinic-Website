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
        this.delayMilliseconds = 2000;
        this.events();
        this.isOverlayOpen = false;
        this.isLoadingResults = false;
    }

    // Events
    events(){
        // On mouse click events
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));

        // hook keyboard handlers
        $(document).on("keydown", this.keyPressHandler.bind(this));
        this.searchField.on("keydown", this.liveSearcher.bind(this));
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
        if(e.keyCode == 83) { // "s" key pressed - open overlay
            this.openOverlay();
        }
    }

    liveSearcher(){
        clearTimeout(this.delayedLiveSearch);
        if(!this.isLoadingResults){
            this.resultsDiv.html('<div class="spinner-loader"></div>');
            this.isLoadingResults = true;
        }              
        this.delayedLiveSearch = setTimeout(this.getResults.bind(this), this.delayMilliseconds)

    }

    getResults(){
        this.resultsDiv.html("Imagine this actually did something");
    }

}

export default LiveSearch;