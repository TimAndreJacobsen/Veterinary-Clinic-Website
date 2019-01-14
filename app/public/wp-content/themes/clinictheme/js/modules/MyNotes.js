import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events() {
        $(".delete-note").on("click", this.deleteNote);
        $(".edit-note").on("click", this.editNote);
    }

    // Functions / Methods
    deleteNote(e) {
        var thisNote = $(e.target).parents("li");
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', clinic_data.nonce);
            },
            url: clinic_data.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'DELETE', 
            success: (response)=> {
                thisNote.slideUp();
                console.log("Delete successfull");
                console.log(response);
            },
            error: (response) => {
                console.log("Delete ERROR");
                console.log(response);
            }
        })
    }

    editNote(e) {
        var thisNote = $(e.target).parents("li");
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        thisNote.find(".update-note").addClass("update-note--visible");
    }


}

export default MyNotes;