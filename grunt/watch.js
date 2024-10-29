module.exports = {
    gruntfile: {
        files: ['Gruntfile.js'],
        tasks: ['jshint:gruntfile']
    },
    dev: {
        files: ['src/js/shareasale.js', 'src/js/shareasale-admin.js'],
        tasks: ['jshint:src', 'uglify:dev']
    },
    images: {
    	files: ['src/img/**/*.jpg'],
    	tasks: ['copy:dev']
    }
};
