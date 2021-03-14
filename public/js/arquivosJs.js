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

/*cadastro produtos
function preecheCampos(id_prod, nomeProd, descricao, detalhes,
    fornecedor, estoque, preco, categoria) {

    document.getElementById("nome").value = nomeProd;
    document.getElementById("descricao").value = descricao;
    document.getElementById("detalhes").value = detalhes;
    document.getElementById("fornecedor").value = fornecedor;
    document.getElementById("estoque").value = estoque;
    document.getElementById("preco").value = preco.replace('.', ',');
    document.getElementById("id_prod").value = id_prod;
    document.getElementById("categoria").value = categoria;
}

function setQuantidade(btn) {

    btn = parseInt(btn);
    var valor = parseInt(document.getElementById("quant").value);
    if (valor < 1 || valor == 1 && btn == -1) {
        document.getElementById("quant").value = 1;
        return;
    }

    if (btn == -1 && valor > 1) {
        document.getElementById("quant").value = (valor - 1);
    } else {
        document.getElementById("quant").value = (valor + 1);
    }
}
   /* document.getElementById('status').innerHTML = "Sending...";
formData = {
'name'     : $('input[name=name]').val(),
'email'    : $('input[name=email]').val(),
'subject'  : $('input[name=subject]').val(),
'message'  : $('textarea[name=message]').val()
}*/

/*
$.ajax({
url : "mail.php",
type: "POST",
data : formData,
success: function(data, textStatus, jqXHR)
{

$('#status').text(data.message);
if (data.code) //If mail was sent successfully, reset the form.
$('#contact-form').closest('form').find("input[type=text], textarea").val("");
},
error: function (jqXHR, textStatus, errorThrown)
{
$('#status').text(jqXHR);
}
});*/
