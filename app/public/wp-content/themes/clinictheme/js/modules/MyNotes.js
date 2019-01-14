import $ from 'jquery';

class MyNotes {
    constructor() {
        
    }

    events() {
        $(".delete-note").on("click", this.deleteNote);
    }

    // Functions / Methods
    deleteNote() {
        alert("BLAH");
    }



}

export default MyNotes;