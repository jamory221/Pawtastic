$(document).ready(function(){
    
    $('#menu').click(function(){
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });

    $(window).on('scroll load',function(){
        $('#menu').removeClass('fa-times');
        $('.navbar').removeClass('nav-toggle');

        if($(window).scrollTop() > 0){
            $('header').addClass('sticky');
        }
        else{
            $('header').removeClass('sticky');
        }

    });
});

let previewContainer = document.querySelector('.pet-preview');
let previewBox = previewContainer.querySelectorAll('.preview');

document.querySelectorAll('.pets-container .pet').forEach(product=>{
    product.onclick = () =>{
        previewContainer.style.display = 'flex';
        let name = product.getAttribute('data-name');
        previewBox.forEach(preview =>{
            let target = preview.getAttribute('data-target');
            if(name == target){
                preview.classList.add('active');
            }
        });
    };
});

previewBox.forEach(close =>{
    close.querySelector('.fa-times').onclick = () =>{
        close.classList.remove('active');
        previewContainer.style.display = 'none';
    };
});

