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
    }
  }
});

export default store;