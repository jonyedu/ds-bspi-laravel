<template>
    <div class="card" >
        <center>
            <div class="card-body">
                <div v-if="url!=''">
                    <a :href="url+'#view=fit'" target="blank" class="btn btn-dark" :style="'width: '+ancho+';'" style="color:white;margin-bottom:5px;font-size:small;">Previsualizar En Nueva Pestaña</a><br>
                    <iframe v-if="extension=='.pdf'" :src="url+'#view=fit'" frameborder="0" :style="'width: '+ancho+';height: '+alto+';'"></iframe>
                    <img v-else :src="url" alt="Imagen Eliminada del Servidor..." :style="'width: '+ancho">
                </div>
                <div v-else>
                    <div v-bind:style="'width: '+ancho+';height: '+alto+';'"  style="color:white;background-color:#555555;padding:15px;">
                        <div style="width:100%;height:100%;border-style:solid;border-color:white;border-radius:20px;display:flex;flex-direction:column;align-items:center;justify-content:center">
                            <div v-if="esTabla">
                                <h5>Haz <b>Click</b> en un Registro</h5>
                                <h6> - Para Previsualizar el Archivo - </h6><br>
                            </div>
                            <div v-else>
                                <h5><b>Carga</b> un Archivo</h5>
                                <h6> - Para Poder Previsualizarlo - </h6><br>
                            </div>
                            
                            <div style="display:inline">
                                <span class="fas fa-file-pdf mr-2" style="font-size:6rem"></span>
                                <span class="fas fa-file-image" style="font-size:6rem"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </center>
    </div>
</template>
<script>
export default {
    props: {
        url:{
            type: String,
            required: true
        },
        size:{
            type: Array
        },
        esTabla:{
            type: Boolean,
            default: true
        },
        blobType:{
            tyoe: String
        }
    },
    watch: { 
        url: function(newVal, oldVal) { // watch it
            this.calculaExt()
        }
    },
    data: function() {
        return {
            extension: "",
            ancho: (this.$props.size && this.$props.size[0])?this.$props.size[0]:"100%",
            alto: (this.$props.size && this.$props.size[1])?this.$props.size[1]:"450px",
        };
    },
    mounted(){
        this.calculaExt()
    },
    methods:{
        calculaExt(){
            let fullstr = this.$props.url;
            this.extension = fullstr.substr(fullstr.lastIndexOf('.'));
            if(this.$props.blobType=='pdf'){
                this.extension = '.pdf'
            }
        }
    }
}
</script>