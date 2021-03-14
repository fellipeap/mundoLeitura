//alert('Este é um site teste 2');
function teste() {
    console.log("teste");
    alert('Este é um site teste 2');
}

function selecionaImg(id_img, nome_extensao) {
    console.log(nome_extensao);
   
    var novaImg = "/img/" + nome_extensao;
    console.log(novaImg);
    console.log(id_img);
    document.getElementById("imgSelecionada").textContent = "";
    document.getElementById("id_img_selec").value = id_img;
    document.getElementById("nome_extensao").src = novaImg;
     
}