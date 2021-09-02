const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CompressionPlugin = require("compression-webpack-plugin");
const path = require('path');
module.exports =[
    {
        entry: './app/resources/init_.js',
        plugins: [new MiniCssExtractPlugin({
            filename: "app.css",
        })],
        module: {
            rules: [
                {
                    test: /\.(sa|sc|c)ss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        "css-loader",
                        "sass-loader",
                    ],
                },
            ],
        },
        output: {
            path: path.resolve(__dirname, 'public_html/dist'),
            filename: "app.js",
        },

    },
    {
        entry: './app/resources/js/app.js',
        output: {
            path: path.resolve(__dirname, 'public_html/dist'),
            filename: 'app.js',
        },

    }
];