// JavaScript Document
function getParentForm(el){
    while((el=el.parentNode))
        if(el.nodeName.toLowerCase()=='form')break
    return el
}
function clearInput(el){
    if(el instanceof Array)
        for(var i=0;i<el.length;i++)
            clearInput(el[i])
    el=document.getElementById(el)
    var a
    if(el.tagName.toLowerCase()=='form')
        for(var i in a=el.getElementsByTagName('*')){
            if(/text|email|tel|password|number/.test(a[i].type)){
                if(!a[i].defaultValue)a[i].defaultValue=a[i].value
                a[i].onfocus=function(){this.value=''}
                a[i].onblur=function(){if(this.value=='')this.value=this.defaultValue}
            }           
            if((!!a[i].rel)&&(/(submit)|(reset)/.test(a[i].rel)))a[i].onclick=function(){getParentForm(this)[this.rel]();return false}
        }
}