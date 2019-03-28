import $ from 'jquery';

class MyPets {
    constructor() {
        this.events();
    }

    // =================================================================
    //                       Events
    // =================================================================

    events() {
        $("#my-pets").on("click", ".delete-pet", this.deletePet);            // delete btn
        $("#my-pets").on("click", ".edit-pet", this.editPet.bind(this));     // edit btn
        $("#my-pets").on("click", ".update-pet", this.updatePet.bind(this)); // save btn
        $(".submit-pet").on("click", this.createPet.bind(this));             // new btn
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
                    $(".pet-limit-message").removeClass("active");
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
            'title': thisPet.find(".pet-title-field").val(),
            'content': thisPet.find(".pet-body-field").val()
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', clinic_data.nonce);
            },
            url: clinic_data.root_url + '/wp-json/wp/v2/pet/' + thisPet.data('id'),
            type: 'POST', 
            data: petUpdates,
            success: (response)=> {
                this.makePetReadOnly(thisPet);
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
            'title': $(".new-pet-title").val(),
            'content': $(".new-pet-body").val(),
            'status': 'private'
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', clinic_data.nonce);
            },
            url: clinic_data.root_url + '/wp-json/wp/v2/pet/',
            type: 'POST', 
            data: newPet,
            success: (response)=> {
                $(".new-pet-title, .new-pet-body").val('');
                $(`<li data-id="${response.id}">
                    <input readonly class="pet-title-field" value="${response.title.raw}">
                    <span class="edit-pet"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
                    <span class="delete-pet"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
                    <textarea readonly class="pet-body-field">${response.content.raw}</textarea>
                    <span class="update-pet btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
                    </li>`).prependTo("#my-pets").hide().slideDown();
                console.log("post/update successfull");
                console.log(response);
            },
            error: (response) => {
                if(response.responseText == "Per user pet limit is 10 pets, please delete a pet to free up space.") {
                    $(".pet-limit-message").addClass('active');
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
        thisPet.find(".edit-pet").html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
        thisPet.find(".pet-title-field, .pet-body-field").removeAttr("readonly").addClass("pet-active-field");
        thisPet.find(".update-pet").addClass("update-pet--visible");
        thisPet.data("state", "editable");
    }

    makePetReadOnly(thisPet){
        thisPet.find(".edit-pet").html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit');
        thisPet.find(".pet-title-field, .pet-body-field").attr("readonly", "readonly").removeClass("pet-active-field");
        thisPet.find(".update-pet").removeClass("update-pet--visible");
        thisPet.data("state", "cancel");
    }

}

export default MyPets;