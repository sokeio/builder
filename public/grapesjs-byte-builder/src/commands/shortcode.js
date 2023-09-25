export default (editor, opts = {}) => {
    const command = editor.Commands;
    const openDialog = function (model) {
      if (window.openShortcodeSetting) {
        console.log(model.get("content"));
        window.openShortcodeSetting(
          editor.getContainer(),
          model.get("content"), // Truyền các tham số mặc định của shortcode vào đây
          [],
          "",
          function ($content) {
            const modelId = model.getId();
            console.log("ID của model là:", modelId);
            model.set(
              "content",
              '<div data-gjs-type="shortcode">' + $content + "</div>"
            );
            model.trigger("change:content");
          }
        );
      }
    };
    command.add("open-shortcode-dialog", {
      run: function (editor, sender, model) {
        console.log(model);
        const modelId = model.getId();
        console.log("ID của model là:", modelId);
        openDialog(model);
      },
    });
  };
  