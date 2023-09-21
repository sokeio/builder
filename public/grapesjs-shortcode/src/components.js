export default (editor, opts = {}) => {
  const domc = editor.DomComponents;

  domc.addType('SHORT-CODE-COMPONENT', {
    model: {
      defaults: {
        // Default props
      },
    },
    view: {

    },
  });
};
