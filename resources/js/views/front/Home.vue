<template>
  <section class="section section-hero-area" style="margin-top: 90px">
    <div class="container text-sm-center">
      <products-grid
              :items="products"
              :options="options"
      />
    </div>
  </section>
</template>
<script>
  import ProductsGrid from 'vue-products-grid'
  export default {
    name: "Home",
    components:{
      ProductsGrid
    },
    data: () => ({
      //sample data
      products: [
        {
          id: '',
          name:'',
          price:'',
          description:'',
          images:[],
          categories:[]
        }
      ],
      //mapping fields
      mapping: {
        id:   'id',
        name: 'name',
        label: 'category',
        abstract: 'description',
        price: 'price',
        image: 'image',
        isfavorite: 'fav',
        rating: 'stars'
      },
      //sample configuration
      options: {
        color: "#fff",
        title_color: "#555",
        text_color: "#ccc",
        price_color: "#555",
        sale_color: "#ff0000",
        icons_color: "#888",
        rating_color: "#ff0000",
        elevation: "1",
        rating: true,
        favorite: true,
        currency: "€",
        salebox: true,
        elevation: '1',
        btn_1: '<i class="icon-fa icon-fa-heart-o"></i>',
        btn_1_on: '<i class="icon-fa icon-fa-heart"></i>',
        btn_2: '<i class="icon-fa icon-fa-shopping-cart"></i>',
      },
    }),
    methods: {
      fetchData () {
        let self = this;
        axios.get(`/api/admin/products`).then(function (response) {
          let data = response.data.result.data;
          for(let i=0;i<data.length;i++) {
            data[i]['image'] = '/images/'+data[i]['images'][0].image;
            data[i]['label'] = data[i]['categories'][0].name;
            data[i]['price'] = Number(data[i]['price']).toFixed(2);
            data[i]['abstract'] = data[i]['description'];
          }
          self.products = data;
          console.log(self.products);
        });
      },
    },
    mounted () {
      this.fetchData();
    }
  };
</script>
<style>
  .widget-card > .wimg {
    margin: 0 !important;
  }
</style>
