<template>
    <div class="main-content buttons-demo">
        <div class="page-header">
            <h3 class="page-title">Categories</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h6>Manage Categories</h6>
                    </div>
                    <div class="card-body">
                        <div v-if="data">
                            <vue-tree-list
                                    :model="data"
                                    @change-name="onChangeName"
                                    @delete-node="onDel"
                                    @add-node="onAddNode"
                                    default-tree-node-name="new node"
                                    default-leaf-node-name="new leaf"
                                    v-bind:default-expanded="false">
                            </vue-tree-list>
                        </div>
                        <div v-else>
                            <button @click="addRoot">Create Root Category</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import { VueTreeList, Tree, TreeNode } from 'vue-tree-list'
  export default {
    name: 'Categories',
    components: {
      VueTreeList
    },
    data () {
      return {
        newTree: {},
        data: null
      }
    },
    methods: {
      getData() {
        let self = this;
        axios
          .get('/api/admin/categories')
          .then(function (response) {
            if(response.data.result.length) {
                self.createTree(response.data.result);
            }
          });
      },
      onChangeName(param) {
        if(param.newName.length > 2) {
          let self = this;
          axios
            .put('/api/admin/categories/update/' + param.id, {'name': param.newName})
            .then(function (response) {
              self.createTree(response.data.result);
            });
        }
      },
      onAddNode(param) {
        let self = this;
        axios
          .post('/api/admin/categories/'+param.parent.id, { 'name': param.name })
          .then(function (response) {
            self.createTree(response.data.result);
          });
      },
      onDel(param) {
        let self = this;
        axios
          .delete('/api/admin/categories/'+param.parent.id)
          .then(function (response) {
            self.createTree(response.data.result);
          });
      },
      addRoot() {

      },
      createTree(tree) {
        tree[0].dragDisabled = true;
        tree[0].addLeafNodeDisabled = true;
        this.data = new Tree(tree);
      }
    },
    mounted() {
      this.getData();
    }
  }
</script>

<style scoped>

</style>
