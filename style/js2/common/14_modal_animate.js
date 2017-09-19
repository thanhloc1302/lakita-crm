/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('.modal').on('hide.bs.modal', function (e) {
    e.preventDefault();
   // var fadeOutClass = $(this).find(".modal-dialog").attr('class');
    //fadeOutClass = fadeOutClass.replace("fadeIn animated", "");
   // fadeOutClass += ' fadeOut animated';
    $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeOut animated btn-very-lg');
    $(this).modal('toggle');
});
$('.modal').on('show.bs.modal', function () {
   // var fadeInClass = $(this).find(".modal-dialog").attr('class');
  //  fadeInClass = fadeInClass.replace("fadeOut animated", "");
  //  fadeInClass += ' fadeIn animated';
    $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeIn animated btn-very-lg');
});
