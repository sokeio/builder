export default (editor, opts = {}) => {
  const panels = editor.Panels;

  panels.addButton("options", {
    id: "shortcode-button",
    className: "fa fa-code-fork",
    command: "openShortcodeModal",
    attributes: {
      title: "Insert Shortcode",
    },
  });
};
