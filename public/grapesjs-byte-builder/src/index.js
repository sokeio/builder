import loadComponents from "./components";
import loadPanels from "./panels";
import loadCommands from "./commands";
import loadBlocks from "./blocks";
import en from "./locale/en";

export default (editor, opts = {}) => {
  const options = {
    ...{
      i18n: {},
      // default options
    },
    modalImportTitle: "Import",
    modalImportButton: "Import",
    modalImportLabel: "",
    modalImportContent: "",
    importViewerOptions: {},
    textCleanCanvas: "Are you sure you want to clear the canvas?",
    showStylesOnChange: true,
    useCustomTheme: true,
    titleTemplateManager: "Template Manager",
    urlTemplateManager: "",
    ...opts,
  };
  // Add panels
  loadPanels(editor, options);
  // Add commands
  loadCommands(editor, options);
  // Add components
  loadComponents(editor, options);
  // Add blocks
  loadBlocks(editor, options);
  // Load i18n files
  editor.I18n &&
    editor.I18n.addMessages({
      en,
      ...options.i18n,
    });

  editor.on("component:selected", function (model) {
    if (model && model.get("type") === "shortcode") {
      editor.runCommand("open-shortcode-dialog", model);
      return;
    }
    let button = document.createElement("div");
    button.style = "text-align: center;";
    button.classList.add("div-builder-component-plus");
    button.innerHTML =
      "<button class='button-component-plus btn btn-sm btn-primary'>+</button>";
    model.view.el.append(button);
    model.view.el
      .querySelector(".button-component-plus")
      .addEventListener("click", () => {
        let callback = "eventAddComponent" + new Date().getTime();

        let modal = window.ByteManager.openModal(
          {
            $url: options.urlTemplateManager,
            $title: options.titleTemplateManager,
            $size: "modal-xl modal-fullscreen-lg-down",
          },
          { callbackEvent: callback }
        );
        window[callback] = function (template) {
          var newComponent = editor.DomComponents.addComponent(template);
          // Append the new component as a child of the selected component
          model.components().add(newComponent);
          modal.hide();
          // Render the changes
          editor.render();
        };
      });
  });

  editor.on("component:deselected", function (model) {
    model.view.el.querySelector(".div-builder-component-plus")?.remove();
  });
  editor.on("component:dblclick", function (model) {
    if (model && model.get("type") === "shortcode") {
      editor.runCommand("open-shortcode-dialog", model);
    }
  });
  editor.on("block:drag:stop", function (model) {
    if (model && model.get("type") === "shortcode") {
      editor.runCommand("open-shortcode-dialog", model);
    }
  });
  // TODO Remove
  // editor.on('load', () =>
  //   editor.addComponents(
  //       `<div style="margin:100px; padding:25px;">
  //           Content loaded from the plugin
  //       </div>`,
  //       { at: 0 }
  //   ))
};
