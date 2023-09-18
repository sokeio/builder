import { BytePlugin } from "../core/plugin";

export class LiveWireGrapesJSModule extends BytePlugin {
  getKey() {
    return "BYTE_LIVEWIRE_GRAPESJS_MODULE";
  }
  booting() {
    if (window.Livewire) {
      let self = this;
      window.Livewire.directive("grapesjs", ({ el, directive, component }) => {
        // Only fire this handler on the "root" directive.
        if (directive.modifiers.length > 0 || el.livewire____tagify) {
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
              pageManager: {
                pages: [
                  {
                    id: "my-first-page",
                    styles: ".my-page1-el { color: red }",
                    component: '<div class="my-page1-el">Page 1</div>',
                  },
                  {
                    id: "my-second-page",
                    styles: ".my-page2-el { color: blue }",
                    component: '<div class="my-page2-el">Page 2</div>',
                  },
                ],
              },
              ...options,
              panels: {
                myNewPanel: {
                  id: "myNewButton",
                  className: "someClass",
                  command: "someCommand",
                  attributes: { title: "Some title" },
                  active: false,
                },
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
