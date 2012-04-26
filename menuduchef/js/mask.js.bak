function mask_numero(e) {
    e.value=e.value.replace(/\D/g,'');
}

function mask_cpf(e) {
    e.value=e.value.replace(/\D/g,'').replace(/(\d{3})(\d)/,'$1.$2').replace(/(\d{3})(\d)/,'$1.$2').replace(/(\d{3})(\d{1,2})$/,'$1-$2');
}

function mask_cnpj(e) {
    e.value=e.value.replace(/\D/g,'').replace(/^(\d{2})(\d)/,'$1.$2').replace(/^(\d{2})\.(\d{3})(\d)/,'$1.$2.$3').replace(/\.(\d{3})(\d)/,'.$1/$2').replace(/(\d{4})(\d)/,'$1-$2');
}

function mask_site(e) {
    v=e.value.replace(/^http:\/\/?/,'');
    dominio=v;
    caminho='';
    if(v.indexOf('/')>-1) dominio=v.split('/')[0];
    caminho=v.replace(/[^\/]*/,'');
    dominio=dominio.replace(/[^\w\.\+-:@]/g,'');
    caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,'');
    caminho=caminho.replace(/([\?&])=/,'$1');
    if(caminho!='')dominio=dominio.replace(/\.+$/,'');
    v='http://'+dominio+caminho;
    e.value=v;
    if(e.value == 'http://') e.value = '';
    e.onblur = function() {
        if(e.value == 'http://') e.value = '';
    }
}

function mask_data(e) {
    e.value=e.value.replace(/\D/g,'').replace(/(\d{2})(\d)/,'$1/$2').replace(/(\d{2})(\d)/,'$1/$2');
}

function mask_hora(e) {
    e.value=e.value.replace(/\D/g,'').replace(/^(\d{2})(\d)/,'$1:$2');
}

function mask_telefone(e) {
    e.value=e.value.replace(/\D/g,'').replace(/^(\d{4})(\d)/,'$1-$2');
}

function mask_ddd_telefone(e) {
    e.value=e.value.replace(/\D/g,'').replace(/^(\d\d)(\d)/g,'($1) $2').replace(/(\d{4})(\d)/,'$1-$2');
}

function mask_cep(e) {
    e.value=e.value.replace(/\D/g,'').replace(/^(\d{5})(\d)/,'$1-$2');
}

function mask_moeda(e) {
    e.value=e.value.replace(/\D/g,'').replace(/(\d{1})(\d{8})$/,'$1.$2').replace(/(\d{1})(\d{5})$/,'$1.$2').replace(/(\d{1})(\d{1,2})$/,'$1,$2');
}
