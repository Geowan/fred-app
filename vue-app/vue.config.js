"use strict";

const WebpackAssetsManifest = require("webpack-assets-manifest");

const host = "127.0.0.1";
const port = 8081;
const path = require("path");

module.exports = {
    outputDir:"../public/vue-assets/",
    lintOnSave: false,
    // filenameHashing:true,
    productionSourceMap:false,

    filenameHashing: false,
    // delete HTML related webpack plugin
    configureWebpack:function(config){
        let obj = {
            plugins : [
                new WebpackAssetsManifest(),
            ]
        };
        if (process.env.NODE_ENV === "production") {
            obj.optimization =  {
                splitChunks: {
                    chunks: "all",
                    minSize: 200000,
                    maxSize: 244000,
                }
            };
        }
        return obj;
    },
    publicPath: `http://${host}:${port}/`,
    devServer: {
        port,
        host,
        hotOnly: true,
        disableHostCheck: true,
        clientLogLevel: "warning",
        inline: true,
        headers: {
            "Access-Control-Allow-Origin": "*",
            "Access-Control-Allow-Methods": "GET, POST, PUT, DELETE, PATCH, OPTIONS",
            "Access-Control-Allow-Headers": "X-Requested-With, content-type, Authorization"
        },
        watchOptions: {
            poll: true
        }
    },
    chainWebpack: config => {
        config.plugins
            .delete("html")
            .delete("preload")
            .delete("prefetch");
        config
            .entry("app")
            .clear()
            .add("./app.js")
            .end();
        config.resolve.alias
            .set("@", path.join(__dirname, "./"))
    },

};
