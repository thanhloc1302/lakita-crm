/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(".btn-navbar-serach").click(function(e){
    e.preventDefault();
    var modalName = "navbar-search-modal";
     $.ajax({
            url:  $("#base_url").val() +  $("#input_controller").val() + '/search',
            type: "GET",
            data: {
                search_all: $(".input-navbar-serach").val()
            },
            success: data => {
                $("." + modalName).remove();
                var newModal = `<div class="${modalName}"></div>`;
                $(".modal-append-to").append(newModal);
                $(`.${modalName}`).html(data);
            },
            complete: () => $(`.${modalName} .navbar-search-modal`).modal("show")
        });
});
