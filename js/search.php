<script type="text/javascript">
//Artoon Game Search
function json_search()
{
	var artoon = window.artoon || {};

	artoon.game_search = function()
	{
		var gameJson = [];
		var getGameJsonInProgress = false;
		var getGameJsonUrl = 'json_search.php';
		var MAX_SEARCH_RESULTS = 10;
		var currentSelectedGameIndex = 0;
		
		var frameHgt = function()
		{
			$(".game_search_input").live(
			{
				keyup: function()
				{
					resultText('Sorry, we could not find what you were looking for.');
				}
			});
		};

		var resultText = function(text)
		{
			var setHgt = $(".search_slider_space .search_game_list").size();
			
			if (setHgt == 1)
			{
				$(".search_slider_space").html('<span class="default_text">' + text + '</span><a href="http://www.google.com" class="search_game_list search_show_all select">Show all games</a>');
				var totalHgt = 56 + 37;
			}
			else
			{
				var totalHgt = setHgt * 29 + 7;
			}

			$(".search_slider_space").height(totalHgt);

			$(".search_slider_space").stop(true, true).slideDown("fast");
		};


		var init_search = function()
		{
			$(".game_search_input").val("");
			$(".search_slider_space").empty();

			attach_all_games_link();
		
			set_selected_index(0);

			if (!getGameJsonInProgress)
			{
				getGameJsonInProgress = true;
				$.getJSON(getGameJsonUrl, function(data)
				{
					gameJson = data;

					var search_trim = $(".game_search_input").val();

					if ($.trim(search_trim.toLowerCase()) != "")
					{
						search($(".game_search_input").val());
					}
				});
			}
			resultText('Start typing the name of the game you are looking for.');
		};

		var search_trigger = function(val, e)
		{
			var keyCode = e.keyCode;

			if (keyCode === 40 || keyCode == 38)
			{
				if (keyCode === 40)
				{ //arrow down
					currentSelectedGameIndex++;

					if (currentSelectedGameIndex > $(".search_slider_space .search_game_list").length - 1)
					{
						currentSelectedGameIndex = 0;
					}
				}
				else if (keyCode === 38)
				{ //arrow up
					currentSelectedGameIndex--;

					if (currentSelectedGameIndex < 0)
					{
						currentSelectedGameIndex = $(".search_slider_space .search_game_list").length - 1;
					}
				}

				set_selected_index(currentSelectedGameIndex);

			}
			else if (keyCode === 13)
			{ //enter
				var link = $(".search_slider_space .select").attr("href");
				if (typeof link == "undefined")
				{
					link = $(".search_slider_space .search_show_all").attr("href");
				}
				
				window.location = link;
			}
			else
			{
				artoon.game_search.search(val);
			}

			return false;
		};

		var set_selected_index = function(index)
		{
			$(".search_slider_space .search_game_list").removeClass("mouseover");
			$(".search_slider_space .select").removeClass("select");
			$(".search_slider_space .search_game_list").eq(index).addClass("select");
			currentSelectedGameIndex = index;
		};

		var attach_all_games_link = function()
		{
			$(".search_slider_space").append('<span class="default_text">Start typing the name of the game you are lookong for.</span><a href="http://www.google.com" class="search_game_list search_show_all select">Show all games</a>');
			resultText('Start typing the name of the game you are looking for.');
			$(".search_slider_space .search_game_list").bind('mouseover', function()
			{
				$(this).addClass("mouseover");
			});
			$(".search_slider_space .search_game_list").bind('mouseout', function()
			{
				$(this).removeClass("mouseover");
			});
		};

		var search = function(val)
		{
			var $gameList = $(".search_slider_space");
			$gameList.empty();

			var searchCriteria = $.trim(val.toLowerCase());
			var searchHits = 0;
			var i = gameJson.length;
			for (index = 0; index < i; index++)
			{

				if (gameJson[searchHits].name.toLowerCase().indexOf(searchCriteria) != -1 && searchHits < MAX_SEARCH_RESULTS)
				{
					var makeHtml = $('<a class="search_game_list" href="' + gameJson[searchHits].url + '"><img src="images/' + gameJson[searchHits].img + '" width="16" height="16" alt="img search" class="search_game_img" /><span classs="search_game_text" style="position:relative;top:-4px;height:16px;padding-left:7px;display:inline-block;">' + gameJson[searchHits].name + '</span></a>');
					$(makeHtml).appendTo($gameList);
					searchHits++;
				}
			}

			frameHgt()
			attach_all_games_link();

			if (searchHits == 0)
			{
				currentSelectedGameIndex = -1;
				$(".search_slider_space .default_text").show().text("Sorry, we could not find what you were looking for.");
			}
			else
			{
				set_selected_index(0);

				$(".search_slider_space .default_text").hide();
			}

			$(".search_slider_space .search_game_list").bind('mouseover', function()
			{
				set_selected_index($(".search_slider_space .search_game_list").index($(this)));
				$(this).addClass("mouseover");
			});
			$(".search_slider_space .search_game_list").bind('mouseout', function()
			{
				set_selected_index($(".search_slider_space .search_game_list").index($(this)));
				$(this).removeClass("mouseover");
			});
		};

		var hide_result = function()
		{
			if ($(".search_slider_space a.mouseover").length == 0)
			{
				$(".search_slider_space").stop(true, true).slideUp("fast");
			}
		};

		return {
			init_search: init_search,
			search_trigger: search_trigger,
			search: search,
			hide_result: hide_result,
			frameHgt: frameHgt,
			resultText: resultText
		}

	}();//End Object Artoon Game Search.

	//jquery Ready
	$(".game_search_input").focus(function()
	{
		artoon.game_search.init_search();
	});
	$(".game_search_input").blur(function()
	{
		artoon.game_search.hide_result();
	});
	$(".game_search_input").keyup(function(e)
	{
		artoon.game_search.search_trigger($(this).val(), e);
	});
}
</script>