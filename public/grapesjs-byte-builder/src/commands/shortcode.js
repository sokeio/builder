export default (editor, opts = {}) => {
  const command = editor.Commands;
  const openDialog = function (editor, sender, model) {
    if (window.openShortcodeSetting) {
      let div = document.createElement("div");
      div.innerHTML = model.view.el.innerHTML;
      let shortcodeObj = window.getShortcodeObjectFromText(div.innerText);
      window.openShortcodeSetting(
        editor.getContainer(),
        shortcodeObj?.shortcode ?? "",
        shortcodeObj?.attributes ?? [],
        shortcodeObj?.content ?? "",
        function ($content) {
          // model.view.el.innerHTML=$content;
          model.set(
            "content",
            '<div data-gjs-type="shortcode">' + $content + "</div>"
          );
          model.trigger("change:content");
          // Render the changes
          editor.render();
        },
        function () {
          sender.stop();
        }
      );
    }
  };
  command.add("open-shortcode-dialog", {
    run: function (editor, sender, model) {
      openDialog(editor, sender, model);
    },
  });
};
