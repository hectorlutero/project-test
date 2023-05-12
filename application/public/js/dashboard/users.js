$(document).ready(function(){
    const doctype = $("input[name='doctype']").val();
    function setDocFieldsVisibility(doctype){
        if (doctype === 'pf') {
            $("#cpf_field").show().removeClass("hidden");
            $("span.cpf").show().removeClass("hidden");
            $("#cnpj_field").hide().addClass("hidden").val("");
            $("span.cnpj").hide().addClass("hidden");
            $(".col-span-cpf").show().removeClass("hidden");
            $(".col-span-cnpj").hide().addClass("hidden");
        } else {
            $("#cnpj_field").show().removeClass("hidden");
            $("span.cnpj").show().removeClass("hidden");
            $("#cpf_field").hide().addClass("hidden").val("");
            $("span.cpf").hide().addClass("hidden");
            $(".col-span-cnpj").show().removeClass("hidden");
            $(".col-span-cpf").hide().addClass("hidden");
        }
    }
    // alert(doctype)
    if (doctype) {
        setDocFieldsVisibility(doctype)
        if(doctype === 'pf') {
            $('input:radio[name=doctyperd][value=pf]').click();
            $("#cpf_field").val($("#document").val())
        } else if(doctype === 'pj') {
            $('input:radio[name=doctyperd][value=pj]').click();
            $("#cnpj_field").val($("#document").val())
        }
    } else {
        $('input:radio[name=doctyperd][value=pf]').click();
    }

    $("input[name='doctyperd']").on("change", function(){
       const selectedType = $(this).val();
        setDocFieldsVisibility(selectedType)
    });

    $("#cpf_field, #cnpj_field").input(function(){

    });
});
