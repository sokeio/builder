export default (editor, opts = {}) => {
  const command = editor.Commands;

  command.add("openShortcodeModal", {
    run: function (editor, sender) {
      // Open your custom shortcode modal here
      // Example: Show a prompt dialog to enter shortcode details
      const shortcode = prompt("Enter the shortcode:");
      if (shortcode) {
        const component = editor.getSelected();
        if (component) {
          component.set("content", shortcode);
        } else {
          editor.DomComponents.addComponent({
            type: "shortcode",
            content: shortcode,
          });
        }
      }
    },
  });
};
