import $ from 'jquery';

class MyPets {
    constructor() {
        this.events();
    }

    // =================================================================
    //                       Events
    // =================================================================

    events() {
        $("#my-notes").on("click", ".delete-note", this.deletePet);            // delete btn
        $("#my-notes").on("click", ".edit-note", this.editPet.bind(this));     // edit btn
        $("#my-notes").on("click", ".update-note", this.updatePet.bind(this)); // save btn
        $(".submit-note").on("click", this.createPet.bind(this));              // new btn
    }

    // =================================================================
    //                       Functions
    // =================================================================

    deletePet(e) {
        var thisPet = $(e.target).parents("li");
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', clinic_data.nonce);
            },
            url: clinic_data.root_url + '/wp-json/wp/v2/pet/' + thisPet.data('id'),
            type: 'DELETE', 
            success: (response)=> {
                thisPet.slideUp();
                console.log("Delete successfull");
                console.log(response);
                if(response.user_pet_count < 10) {
                    $(".note-limit-message").removeClass("active");
                }
            },
            error: (response) => {
                console.log("Delete ERROR");
                console.log(response);
            }
        })
    }

    updatePet(e) {
        var thisPet = $(e.target).parents("li");
        var petUpdates = {
            'title': thisPet.find(".note-title-field").val(),
            'content': thisPet.find(".note-body-field").val()
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', clinic_data.nonce);
            },
            url: clinic_data.root_url + '/wp-json/wp/v2/pet/' + thisPet.data('id'),
            type: 'POST', 
            data: petUpdates,
            success: (response)=> {
                this.makeNoteReadOnly(thisPet);
                console.log("post/update successfull");
                console.log(response);
            },
            error: (response) => {
                console.log("post/update ERROR");
                console.log(response);
            }
        })
    }

    createPet(e) {
        var newPet = {
            'name': $(".new-note-title").val(),
            'age': $("#age").val(),
            'breed': $("#breed").val(),
            'content': $(".new-note-body").val(),
            'status': 'publish'
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', clinic_data.nonce);
            },
            url: clinic_data.root_url + '/wp-json/wp/v2/pet/',
            type: 'POST', 
            data: newPet,
            success: (response)=> {
                $(".new-note-title, .new-note-body").val('');
                $(`<li data-id="${response.id}">
                    <input readonly class="note-title-field" value="${response.name}">
                    <input readonly class="note-title-field" value="${response.age}">
                    <input readonly class="note-title-field" value="${response.breed}">
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
                    <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
                    </li>`).prependTo("#my-notes").hide().slideDown();
                console.log("post/update successfull");
                console.log(response);
            },
            error: (response) => {
                if(response.responseText == "Per user note limit is 10 notes, please delete a note to free up space.") {
                    $(".note-limit-message").addClass('active');
                }
                console.log("post/update ERROR");
                console.log(response);
            }
        })
    }

    editPet(e) {
        var thisPet = $(e.target).parents("li");
        if (thisPet.data("state") == "editable") {
            this.makePetReadOnly(thisPet);
        } else {
            this.makePetEditable(thisPet);
        }
    }

    makePetEditable(thisPet) {
        thisPet.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
        thisPet.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        thisPet.find(".update-note").addClass("update-note--visible");
        thisPet.data("state", "editable");
    }

    makePetReadOnly(thisPet){
        thisPet.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit');
        thisPet.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
        thisPet.find(".update-note").removeClass("update-note--visible");
        thisPet.data("state", "cancel");
    }

}

export default MyPets;