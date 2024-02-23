import { regexShortcode } from "../consts";

export default (editor, opts = {}) => {
  const command = editor.Commands;
  const openDialog = function (editor, sender, model) {
    
    if (window.openShortcodeSetting) {
      let div = document.createElement("div");
      div.innerHTML = regexShortcode.test(model.get("content"))
        ? model.get("content")
        : decodeURIComponent(model.view.el.getAttribute("data-shortcode"));
      let shortcodeObj = window.getShortcodeObjectFromText(div.innerText);
      window.openShortcodeSetting(
        editor.getContainer(),
        shortcodeObj?.shortcode ?? "",
        shortcodeObj?.attributes ?? [],
        shortcodeObj?.content ?? "",
        function ($content) {
          model.set(
            "content",
            '<div data-gjs-type="shortcode">' + $content + "</div>"
          );
          model.components('<div data-gjs-type="shortcode">' + $content + "</div>");
          model.trigger("change:content");
          editor.trigger("component:update");
          // model.trigger("change");
          // Render the changes
          model.view.render();
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
