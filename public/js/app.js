let urlIndex = "http://localhost:8000/index.php?r=product/index";
let urlView = "http://localhost:8000/index.php?r=product/view";
let urlCreate = "http://localhost:8000/index.php?r=product/create";
let urlUpdate = "http://localhost:8000/index.php?r=product/update";
let urlDelete = "http://localhost:8000/index.php?r=product/delete";

new Vue({
  el: "#app",
  vuetify: new Vuetify(),
  data() {
    return {
      products: [],
      dialog: false,
      dialog2: false,
      action: "",
      currencies: ["USD", "COP"],
      product: {
        id: null,
        description: "",
        reference: "",
        currency: "",
        price: "",
        stock: "",
      },
    };
  },
  created() {
    this.index();
  },
  methods: {
    //MÉTODOS PARA EL CRUD
    index: function () {
      axios.get(urlIndex).then(({ data }) => {
        this.products = data;
      });
    },
    create: function () {
      data = {
        description: this.product.description,
        reference: this.product.reference,
        currency: this.product.currency,
        price: this.product.price,
        stock: this.product.stock,
      };
      axios.post(urlCreate, data).then(({ data }) => {
        if (data.success) {
          this.index();
          this.reset();
          Swal.fire({
            icon: "success",
            title: "Ok!",
            text: data.message,
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: data.message,
          });
        }
      });
    },
    edit: function () {
      data = {
        id: this.product.id,
        description: this.product.description,
        reference: this.product.reference,
        currency: this.product.currency,
        price: this.product.price,
        stock: this.product.stock,
      };
      axios.put(urlUpdate + "/id/" + this.product.id, data).then(({data}) => {
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Ok!",
            text: data.message,
          });
          this.index();
        } else {
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: data.message,
          });
        }
      });
    },
    reset: function () {
      this.product.description = "";
      this.product.reference = "";
      this.product.currency = "";
      this.product.price = "";
      this.product.stock = "";
    },
    //Botones y formularios
    saveRecord: function () {
      if (this.action == "create") {
        this.create();
      }
      if (this.action == "edit") {
        this.edit();
      }
      this.dialog = false;
    },
    newRecord: function () {
      this.dialog = true;
      this.action = "create";
      this.reset();
    },
    editRecord: function (id, description, reference, currency, price, stock) {
      //capturamos los datos del registro seleccionado y los mostramos en el formulario
      this.product.id = id;
      this.product.description = description;
      this.product.reference = reference;
      this.product.currency = currency;
      this.product.price = price;
      this.product.stock = stock;
      this.dialog = true;
      this.action = "edit";
    },
    showRecord: function (id) {
      axios.get(urlView + "/id/" + id).then(( {data} ) => {
        this.product = data;
        this.dialog2 = true;
      });
    },
    deleteRecord: function (id) {
      Swal.fire({
        title: "¿Confirma eliminar el registro?",
        confirmButtonText: "Confirmar",
        showCancelButton: true,
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(urlDelete + "/id/" + id).then((response) => {
            this.index();
          });
          Swal.fire("¡Eliminado!", "", "success");
        } else if (result.isDenied) {
        }
      });
    },
  },
});