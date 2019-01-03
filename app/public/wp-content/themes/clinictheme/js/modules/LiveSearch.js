import $ from 'jquery';

class LiveSearch {
    // Constructor
    constructor(){
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.events();
    }

    // Events
    events(){
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));
        $(document).on("keyup", this.keyPressHandler.bind(this));
    }

    // Functions/Methods
    openOverlay(){
        this.searchOverlay.addClass("search-overlay--active")
        $("body").addClass("body-no-scroll");
    }

    closeOverlay(){
        this.searchOverlay.removeClass("search-overlay--active")
        $("body").removeClass("body-no-scroll");
    }

    keyPressHandler(e){
        console.log(e.keyCode)
        if(e.key === "Escape") { // Escape pressed - close overlay
            this.searchOverlay.removeClass("search-overlay--active")
            $("body").removeClass("body-no-scroll");
        }
        if(e.keyCode == 83) { // Escape pressed - close overlay
            this.searchOverlay.addClass("search-overlay--active")
            $("body").addClass("body-no-scroll");
        }
    }

}

export default LiveSearch;