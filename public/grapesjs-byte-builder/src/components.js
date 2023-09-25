export default (editor, opts = {}) => {
  const domc = editor.DomComponents;

  domc.addType("shortcode", {
    model: {
      defaults: {
        // Default props
      },
    },
    view: {},
  });
};
