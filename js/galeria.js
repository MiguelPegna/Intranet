const images = document.querySelectorAll('.imgG');
const contenedorImagen = document.querySelector('.contenedor-img');
const imageContenedor = document.querySelector('.img-show');
const copy = document.querySelector('.copy');
const closeModal = document.querySelector('.icon.icon-tabler.icon-tabler-x');

images.forEach(image =>{
    image.addEventListener('click', ()=>{
        
        addImage(image.getAttribute('src'),image.getAttribute('alt'))
        
    });
});

const addImage = (srcImg, altImg)=>{
    contenedorImagen.classList.toggle('move');
    imageContenedor.classList.toggle('show');
    imageContenedor.src = srcImg;
    copy.innerHTML = altImg;
}

closeModal.addEventListener('click',()=>{
    contenedorImagen.classList.toggle('move');
    imageContenedor.classList.toggle('show');
})
