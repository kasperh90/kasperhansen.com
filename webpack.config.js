const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");

module.exports = (env, argv) => {
    console.log(`This is the Webpack 5 'mode': ${argv.mode}`);

    return {
        entry: {
            bundle: path.resolve(__dirname, 'less/index.js')
        },
        output: {
            path: path.resolve(__dirname, 'public/assets'),
            filename: argv.mode === 'production' ? '[name].[contenthash].js' : '[name].js',
            publicPath: "assets",
            clean: true,
        },
        devtool: 'source-map',
        module: {
            rules: [
                {
                    test: /\.less$/,
                    exclude: /node_modules/,
                    use: [
                        "style-loader",
                        {
                            loader: MiniCssExtractPlugin.loader,
                            options: {
                                esModule: false,
                            },
                        },
                        "css-loader",
                        "less-loader",
                        {
                            loader: "postcss-loader",
                            options: {
                                postcssOptions: {
                                    plugins: [
                                        [
                                            "autoprefixer",
                                        ],
                                    ],
                                },
                            },
                        },
                    ],
                },
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        },
                    },
                },
            ],
        },
        plugins: [
            new HtmlWebpackPlugin({
                filename : '../templates/assets/bundle.html',
                template: 'less/index.html',
                inject: false,
            }),
            new MiniCssExtractPlugin({
                filename: argv.mode === 'production' ? '[name].[contenthash].css' : '[name].css',
            })
        ],
        optimization: {
            minimize: true,
            minimizer: [
                new CssMinimizerPlugin(),
                new TerserPlugin(),
            ],
        },
    };
};