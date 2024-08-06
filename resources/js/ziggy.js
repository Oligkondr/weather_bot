const Ziggy = {"url":"http:\/\/localhost:60020","port":60020,"defaults":{},"routes":{"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"welcome":{"uri":"\/","methods":["GET","HEAD"]},"telegram.webhook":{"uri":"telegram\/webhook","methods":["POST"]},"telegram.bot":{"uri":"telegram\/bot\/{token}","methods":["GET","HEAD"],"parameters":["token"]},"telegram.bind":{"uri":"telegram\/bot\/{client}","methods":["POST"],"parameters":["client"],"bindings":{"client":"id"}},"login":{"uri":"login","methods":["GET","HEAD"]},"send":{"uri":"send","methods":["POST"]},"code":{"uri":"code\/{login}","methods":["GET","HEAD"],"parameters":["login"]},"auth":{"uri":"auth\/{login}","methods":["POST"],"parameters":["login"]},"telegram.logout":{"uri":"logout","methods":["POST"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
