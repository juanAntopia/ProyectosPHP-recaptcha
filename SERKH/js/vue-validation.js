const app = new Vue({
    el: '#app',
    data:{
        errors: [],
        nombre: '',
        asunto: '',
        mail: '',
        message: ''
    },
    methods:{
        
        checkform: function(e){
            var recaptcha_response_value = event.target['g-recaptcha-response'].value;

            this.errors = [];

            if(this.nombre && this.asunto && this.mail && this.message && recaptcha_response_value){
                return true;
            }

            if (!recaptcha_response_value){
                this.errors.push('El recaptcha es obligatorio'); 
            }

            if(!this.nombre){
                this.errors.push('El nombre es obligatorio');
            }

            if (!this.validNombre(this.nombre)) {
                this.errors.push('Solo letras en campo *nombre');
            }

            if(!this.asunto){
                this.errors.push('El asunto es obligatorio');
            }

            if(!this.mail){
                this.errors.push('EL email es obligatorio');
            }
            
            if(!this.validEmail(this.mail)){
                this.errors.push('El email no es válido');
            }

            if(!this.message){
                this.errors.push('El mensaje es obligatorio');
            }

            
           

            if(!this.errors.length){
                return true;
            }


            e.preventDefault();
        },
        validEmail: function (email) {
            var expr = /.+@.+\..+/;
            return expr.test(email)
        },
        validNombre: function (nombre) {
            var expr = /^[a-zA-Z-ñáéíóú ]*$/;
            return expr.test(nombre)
        },
    }
});