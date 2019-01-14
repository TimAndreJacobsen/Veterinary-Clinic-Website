import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events() {
        $(".delete-note").on("click", this.deleteNote);
    }

    // Functions / Methods
    deleteNote() {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', clinic_data.nonce);
            },
            url: clinic_data.root_url + '/wp-json/wp/v2/note/205',
            type: 'DELETE', 
            success: (response)=> {
                console.log("Delete successfull");
                console.log(response)
            },
            error: (response) => {
                console.log("Delete ERROR");
                console.log(response)
            }
        })
    }


}

export default MyNotes;