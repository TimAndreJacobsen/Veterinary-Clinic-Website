import $ from 'jquery';

class LiveSearch {
    // Constructor
    constructor(){
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.delayedLiveSearch;
        this.delayMilliseconds = 1000;
        this.events();
        this.isOverlayOpen = false;
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
        if(e.keyCode == 83) { // Escape pressed - close overlay
            this.openOverlay();
        }
    }

    liveSearcher(){
        clearTimeout(this.delayedLiveSearch);
        this.delayedLiveSearch = setTimeout(function() {console.debug("Timeout checker on typing");}, this.delayMilliseconds)
    }

}

export default LiveSearch;