import { BytePlugin } from "../core/plugin";

export class LiveWireGrapesJSModule extends BytePlugin {
  getKey() {
    return "BYTE_LIVEWIRE_GRAPESJS_MODULE";
  }
  booting() {
    if (window.Livewire) {
      let self = this;
      let manager = self.getManager();
      window.Livewire.directive("grapesjs", ({ el, directive, component }) => {
        // Only fire this handler on the "root" directive.
        if (directive.modifiers.length > 0 || el.livewire____grapesjs) {
          return;
        }
        let options = {};

        if (el.hasAttribute("wire:grapesjs.options")) {
          options = new Function(
            `return ${el.getAttribute("wire:grapesjs.options")};`
          )();
        }
        const grapesjsCreate = () => {
          if (!el.livewire____grapesjs) {
            el.livewire____grapesjs = grapesjs.init({
              // Indicate where to init the editor. You can also pass an HTMLElement
              container: el,
              storageManager: false,
              style: manager.dataGet(component.$wire, "cssdata"),
              // HTML string or a JSON of components
              components: manager.dataGet(component.$wire, "htmldata"),
              ...options,
            });
            el.livewire____grapesjs.Panels.addButton("options", [
              {
                id: "save-builder-html",
                className: "fa fa-save",
                command: "save-data",
                attributes: {
                  title: "Save Changes",
                },
              },
            ]);
            el.livewire____grapesjs.Commands.add("save-data", {
              run: async function (editor, sender) {
                sender && sender.set("active", 0); // turn off the button
                manager.dataSet(
                  component.$wire,
                  "cssdata",
                  el.livewire____grapesjs.getCss()
                );
                manager.dataSet(
                  component.$wire,
                  "htmldata",
                  el.livewire____grapesjs.getHtml()
                );
                component.$wire.doSaveBuilder();
              },
            });
          }
        };
        if (window.grapesjs) {
          grapesjsCreate();
        } else {
          window.addStyleToWindow(
            "https://cdn.jsdelivr.net/npm/grapesjs@0.21.6/dist/css/grapes.min.css",
            function () {}
          );
          window.addScriptToWindow(
            "https://cdn.jsdelivr.net/npm/grapesjs@0.21.6/dist/grapes.min.js",
            function () {
              grapesjsCreate();
            }
          );
        }
      });
    }
  }
}
