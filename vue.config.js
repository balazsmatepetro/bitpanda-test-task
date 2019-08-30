module.exports = {
  css: {
    loaderOptions: {
      sass: {
        data: `
          @import "@/scss/_variables.scss";
          @import "node_modules/bulma/sass/utilities/mixins";
        `
      }
    }
  }
};
