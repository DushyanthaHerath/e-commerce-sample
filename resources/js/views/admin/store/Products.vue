<template>
    <div class="main-content buttons-demo">
        <div class="page-header">
            <h3 class="page-title">Products</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <button class="btn btn-default" @click="openAddProduct">Add Product</button>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h6>Products</h6>
                    </div>
                    <div class="card-body">
                        <table-component :data="fetchData" table-class="table" ref="table">
                            <table-column show="name" label="Name"/>
                            <table-column show="price" label="Price"/>
                            <table-column show="description" label="Description"/>
                            <table-column
                                    :sortable="false"
                                    :filterable="false"
                                    label="Images"
                            >
                                <template slot-scope="row">
                                    <div>
                                        <img style="max-width:100px;height:auto;" v-for="i in row.images" :src="'/images/' + i.image" class="rounded float-left" alt="...">
                                    </div>
                                </template>
                            </table-column>
                            <table-column
                                    :sortable="false"
                                    :filterable="false"
                                    label=""
                            >
                                <template slot-scope="row">
                                    <div>
                                        <a @click="editProduct(row.id)">Edit</a>
                                        <a @click="deleteProduct(row.id)">Delete</a>
                                    </div>
                                </template>
                            </table-column>
                        </table-component>
                    </div>
                </div>
            </div>
        </div>
        <sweet-modal
                ref="product_modal"
                modal-theme="dark"
                overlay-theme="dark"
        >
            <div class="text-left">
                <div class="form-group">
                    <label>Categories</label>
                    <select class="form-control fix-height" style="border-radius:0;" v-model="product.categories" multiple="true">
                        <option :selected="product.categories && product.categories.includes(c.id)" v-for="c in categories" :value="c.id">{{c.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" type="text" name="name" v-validate="{required: true}" v-model="product.name">
                    <span>{{ errors.first('name') }}</span>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input class="form-control" type="text" name="price" v-validate="{required: true}" v-model="product.price">
                    <span>{{ errors.first('price') }}</span>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" type="text" name="description" v-validate="{required: true}" v-model="product.description"></textarea>
                    <span>{{ errors.first('description') }}</span>
                </div>
                <div class="form-group">
                    <label>Images</label>
                    <div>
                        <vue-dropzone ref="myVueDropzone" @vdropzone-success="imageUploaded" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-default" @click="submit()">Submit</button>
            </div>
        </sweet-modal>
    </div>
</template>

<script>
  import { SweetModal, SweetModalTab } from 'sweet-modal-vue'
  import { TableComponent, TableColumn } from 'vue-table-component'
  import vueDropzone from 'vue2-dropzone'

  export default {
    name: 'Products',
    data() {
      return {
        categories: {},
        product: {
          name:'',
          price:'',
          description:'',
          images:[],
          categories:[]
        },
        dropzoneOptions: {
          url: '/api/imageUpload'
        },
      }
    },
    components: {
      TableComponent,
      TableColumn,
      SweetModal,
      SweetModalTab,
      vueDropzone
    },
    methods: {
      async fetchData ({ page, filter, sort }) {
        const response = await axios.get(`/api/admin/products?page=${page}&sort=${sort.fieldName}&order=${sort.order}`)

        return {
          data: response.data.result.data,
          pagination: {
            totalPages: response.data.result.last_page,
            currentPage: page,
            count: response.data.result.data.count
          }
        }
      },
      openAddProduct() {
        this.$refs.product_modal.open();
      },
      getCategories() {
        let self = this;
        axios
          .get('/api/admin/categories/leafs')
          .then(function (response) {
            self.categories = response.data.result;
          });
      },
      imageUploaded(file, response) {
        this.product.images.push(response.filename);
      },
      submit() {
        let self = this;
        this.$validator.validate().then(valid => {
          if (valid) {
            axios
              .post('/api/admin/products', this.product)
              .then(function (response) {
                self.$refs.table.refresh();
              });
          }
        });
      },
      deleteProduct(id) {
        let self = this;
        axios
          .delete(`/api/admin/products/${id}`)
          .then(function (response) {
            self.$refs.table.refresh();
          });
      },
      editProduct(id) {
        let self = this;
        axios
          .get(`/api/admin/products/${id}`)
          .then(function (response) {
            self.product = response.data.result;
            self.product.categories = self.product.categories.map(function (item) {
              return item.id;
            });
            self.$refs.product_modal.open();
          });
      }
    },
    mounted () {
      this.getCategories();
    }
  }
</script>

<style scoped>

</style>
