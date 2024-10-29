module.exports = {
    dev: {
    	files: [
      		{expand: true, flatten: true, src: ['src/img/*'], dest: 'build/img-dev/', filter: 'isFile'}
      	]
    },
    prod: {
    	files: [
    		{expand: true, flatten: true, src: ['src/img/*'], dest: 'build/img/', filter: 'isFile'}
    	]
    }
};
