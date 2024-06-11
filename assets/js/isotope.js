jQuery(() => {
	//filter products
	// quick search regex
	var qsRegex;
	var buttonFilter;
	var sliderMinVal;
	var sliderMaxVal;

	var $grid = $('.grid').isotope({
		// options
		itemSelector: '.grid-item',
		layoutMode: 'fitRows',
		percentPosition: true,
		getSortData: {
			price: function(itemElem) {
				var price = $(itemElem).find('.item-price').attr('data-price');
				return parseFloat(price);
			}
		},

		filter: function() {
			var $this = $(this);
			var priceVal = $this.find('.item-price').attr('data-price');
			var searchResult = qsRegex ? $this.text().match(qsRegex) : true;
			var buttonResult = buttonFilter ? $this.is(buttonFilter) : true;
			var filterPriceResult = filterPrice(priceVal, sliderMinVal, sliderMaxVal);
			return filterPriceResult && (searchResult && buttonResult);
		}
	});

	$('.filter-ascending-list').on('click', 'li label', function() {
		var sortType = $(this).attr('data-sort-type');
		var sortValue = $(this).attr('data-sort-value');
		$grid.isotope({
			sortBy: sortValue,
			sortAscending: sortType == 'high-low' ? false : true
		});
	});

	$('.filter-brand-list').on('click', 'li label', function() {
		buttonFilter = $(this).attr('data-sort-value');
		$grid.isotope();
	});

	// use value of search field to filter
	var $quicksearch = $('.search-input').keyup(
		debounce(function() {
			qsRegex = new RegExp($quicksearch.val(), 'gi');
			$grid.isotope();
		}, 200)
	);

	// debounce so filtering doesn't happen every millisecond
	function debounce(fn, threshold) {
		var timeout;
		threshold = threshold || 100;
		return function debounced() {
			clearTimeout(timeout);
			var args = arguments;
			var _this = this;
			function delayed() {
				fn.apply(_this, args);
			}
			timeout = setTimeout(delayed, threshold);
		};
	}

	$('select#brands').on('change', function(e) {
		var optionSelected = $('option:selected', this);
		buttonFilter = this.value;
		$grid.isotope();
	});

	$('.filter-button').on('click', function(e) {
		const priceInputs = $('.price-input input');
		sliderMinVal = parseInt(priceInputs[0].value);
		sliderMaxVal = parseInt(priceInputs[1].value);

		$grid.isotope();
	});

	function filterPrice(priceVal, minVal = 0, maxVal = 10000) {
		return minVal <= parseFloat(priceVal) && maxVal >= parseFloat(priceVal);
	}
});
