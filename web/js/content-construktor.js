let Content;

Content = {
	
	url         : null,
	targetBlock : '.list-items',
	templates   : {},
	keyTemplate : '',
	items       : [],
	HtmlItem    : '',
	HtmlItems   : [],
	params      : [],
	currentUrl  : {},
	parameters  : {},
	
	init : function(params) {
		for (var index in params) {
			if (this.hasOwnProperty(index)) {
				this[index] = params[index];
			}
		}
		
		this.currentUrl = this.parseURL(document.location);
		
		if (this.url) {
			this.parameters = this.parseURL(this.url).parametersObject;
		}
		
		return this;
	},
	
	run : function() {
		try {
			this.updateUrl(this.parameters);
			this.renderData();
			this.templateParse();
			this.insertItems();
		} catch (e) {
			return;
		}
	},
	
	templateParse : function() {
		this.HtmlItems = [];
		
		$.each(this.items, function(index, item) {
			
			Content.HtmlItem = Content.templates[Content.keyTemplate];
			$.each(item, function(key, value) {
				Content.HtmlItem = Content.HtmlItem.split('{' + key + '}').join(value);
			});
			Content.HtmlItems.push(Content.HtmlItem);
		});
	},
	
	insertItems : function() {
		let resultHtml = '';
		
		$.each(this.HtmlItems, function(index, item) {
			resultHtml += (index % 4 === 0) ? "<div class='row'>" : '';
			resultHtml += item;
			resultHtml += ((index && (index + 1) % 4 === 0) || Content.HtmlItems.length === index + 1) ? "</div>" : '';
		}, resultHtml);
		
		$(this.targetBlock).html(resultHtml);
	},
	
	updateUrl : function(parameters) {
		
		for (var index in parameters) {
			this.currentUrl.parametersObject[index] = parameters[index];
		}
		
		this.url = this.currentUrl.createUrl();
		history.pushState(null, null, this.url);
	},
	
	renderData : function() {
		$.ajax({
			type     : "POST",
			dataType : 'json',
			async    : false,
			url      : Content.url,
			success  : function(response) {
				Content.items = response.items;
				Content.templates[Content.keyTemplate] = response.template;
			},
			error    : function(error) {
				throw Error(error.responseText);
			},
		});
	},
	
	doSorting : function(sortByField) {
		this.items.sort(this.dynamicSort(sortByField));
		
		this.updateUrl({sort : sortByField});
		this.templateParse();
		this.insertItems();
	},
	
	dynamicSort : function dynamicSort (property) {
		var sortOrder = 1;
		if (property[0] === "-") {
			sortOrder = -1;
			property  = property.substr(1);
		}
		return function(a, b) {
			if (a[property] === b[property]) {
				return 0;
			}
			
			var result = (a[property] < b[property]) ? -1 : 1;
			return result * sortOrder;
		};
	},
	
	parseURL : function(url) {
		let parser       = document.createElement('a'),
		    parametersObject = {},
		    queries,
		    split,
		    i;
		// Let the browser do the work
		parser.href      = url;
		// Convert query string to object
		queries          = parser.search.replace(/^\?/, '').split('&');
		for (i = 0; i < queries.length; i++) {
			split                  = queries[i].split('=');
			parametersObject[split[0]] = split[1];
		}
		return {
			origin           : parser.origin,
			protocol         : parser.protocol,
			host             : parser.host,
			hostname         : parser.hostname,
			port             : parser.port,
			pathName         : parser.pathname,
			search           : parser.search,
			parametersObject : parametersObject,
			hash             : parser.hash,
			createUrl        : function() {
				let params = [];
				
				for (var index in this.parametersObject) {
					params.push(index + '=' + this.parametersObject[index]);
				}
				
				return this.origin + this.pathName + '?' + params.join('&');
			},
		};
	},
};
