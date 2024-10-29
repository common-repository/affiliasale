module.exports = {
    dev: {
        options: {
          beautify: true,
          mangle: false,
          compress: false
        },
        files: {
            'build/js-dev/shareasale.js': ['src/js/shareasale.js'],
            'build/js-dev/shareasale-admin.js': ['src/js/shareasale-admin.js'],
        }
    },
    prod: {
        files: {
            'build/js/shareasale.min.js': ['src/js/shareasale.js'],
            'build/js/shareasale-admin.min.js': ['src/js/shareasale-admin.js'],
        }
    }
};
