<template>
  <div>
    <h1 class="text-center">Administrar Producto</h1>
    <hr />
    <!-- Button to Open the Modal -->
    <button @click="modificar=false; abrirModal();" type="button" class="btn btn-primary my-4">Nuevo Producto</button>
    <!-- The Modal -->
    <div class="modal" :class="{mostrar: modal}">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">{{tituloModal}}</h4>
            <button @click="cerrarModal();"  type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
            <div class="my-4">
              <label for="descripcion">Descripcion</label>
              <input v-model="articulo.descripcion" type="text" class="form-control" id="descripcion" placeholder="Descripcion del Articulo">
             <span class="text-danger" v-if="errores.descripcion">{{errores.descripcion[0]}}</span>
            </div>
             <div class="my-4">
              <label for="precio">Precio</label>
              <input v-model="articulo.precio" type="number" class="form-control" id="precio" placeholder="Precio del Articulo">
               <span class="text-danger" v-if="errores.precio">{{errores.precio[0]}}</span> 
            </div>
            <div class="my-4">
              <label for="stock">Stock</label>
              <input v-model="articulo.stock" type="number" class="form-control" id="stock" placeholder="Stock del Articulo">
              <span class="text-danger" v-if="errores.stock">{{errores.stock[0]}}</span>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button @click="cerrarModal();" type="button" class="btn btn-secondary" data-dismiss="modal">
              Cancelar
            </button>
            <button  @click="guardar();" type="button" class="btn btn-success" data-dismiss="modal">
              Guardar
            </button>
          </div>
        </div>
      </div>
    </div>
    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Cod</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Precio</th>
          <th scope="col">Stock</th>
          <th scope="col" colspan="2" class="text-center">Accion</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="art in articulos.data" :key="art.id">
          <th scope="row">{{ art.id }}</th>
          <td>{{ art.descripcion }}</td>
          <td>{{ art.precio }}</td>
          <td>{{ art.stock }}</td>
          <td>
            <button  @click="modificar=true; abrirModal(art);" class="btn btn-secondary">Editar</button>
          </td>
          <td>
            <button @click="eliminar(art.id)" class="btn btn-danger">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <pagination :data="articulos" @pagination-change-page="getResults"></pagination>
  </div>
</template>
<script>
export default {
  data() {
    return {
      articulo:{
        descripcion:'yuu',
         nombre:'88',
        stock:1,
      },
      id:0,
      modificar:true,
      modal:0,
      tituloModal:'',
      articulos: [],
      errores:{},
      pagination:{
        page:1,
        per_page:5,
      },
    };
  },
  methods: {
    async listar() {
      const res = await axios.get('/articulos',{params: this.pagination} );
      this.articulos = res.data;
    },
    async eliminar(id) {
      const res = await axios.delete('/articulos/' + id);
      this.listar();
    },
    async guardar() {
     try {
        if(this.modificar){
        const res = await axios.put('/articulos/'+this.id, this.articulo);
        // console.log(this.id);
      }else{
        const res = await axios.post('/articulos/', this.articulo);
      }
      this.cerrarModal();
      this.listar();       
     } catch (error) {
       if(error.response.data){
         this.errores=error.response.data.errores
       }
     }     
    },
    abrirModal(data={}){
      this.modal=1;
      if(this.modificar){
        this.id=data.id;
        this.tituloModal="Modificar Producto";
        this.articulo.descripcion=data.descripcion;
         this.articulo.precio=data.precio;
        this.articulo.stock=data.stock;
      }else{
        this.id=0;
        this.tituloModal="Crear Producto";
        this.articulo.descripcion='';
        this.articulo.precio='';
        this.articulo.stock=1;
      }
    },
    cerrarModal(){
      this.modal=0;
      this.errores={};
    },
  },
  created() {
    this.listar();
  },
};
</script>
<style>
  .mostrar{
    display: list-item;
    opacity: 1;
    background: rgba(75, 56, 143, 0.705);
  }
</style>