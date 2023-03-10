import { createStore } from 'vuex'

const store = createStore({
  state: {
    user:{
      data:{},
      token: null
    },
    nav: {
      resto: "",
      rubrique: "",
      article: ""
    },
    BaseUrl:""
  }
});

export default store;