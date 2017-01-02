(function($) {
	$.fn.slideTabs = function(b) {
		var c = {
			autoplay: false,
			autoplayClickStop: false,
			autoplayInterval: 5000,
			autoHeight: false,
			autoHeightTime: 0,
			buttonsFunction: 'slide',
			classBtnDisabled: 'st_btn_disabled',
			classBtnNext: 'st_next',
			classBtnPrev: 'st_prev',
			classExtLink: 'st_ext',
			classTab: 'st_tab',
			classTabActive: 'st_tab_active',
			classTabsContainer: 'st_tabs_container',
			classTabsList: 'st_tabs',
			classView: 'st_view',
			classViewActive: 'st_active_view',
			classViewContainer: 'st_view_container',
			contentAnim: 'slideH',
			contentAnimTime: 600,
			contentEasing: 'easeInOutExpo',
			offsetBR: 0,
			offsetTL: 0,
			orientation: 'horizontal',
			tabSaveState: false,
			tabsAnimTime: 300,
			tabsEasing: '',
			tabsScroll: true,
			tabsSlideLength: 0,
			totalHeight: 0,
			totalWidth: 0,
			urlLinking: false,
			changeSlide:function(){}
		},
			conf = $.extend(true, {}, c, b);
		return this.each(function() {
				var a = new SlideTabs($(this), conf);
				a.init()
			})
	};

	function SlideTabs(d, e) {
		var f = d.find('.' + e.classTabsContainer),
			$tabsInnerCont = f.children('div').first(),
			$tabs = f.find('.' + e.classTabsList),
			$a = $tabs.children('li').find('a'),
			$contentCont = d.find('.' + e.classViewContainer),
			$content = $contentCont.find('.' + e.classView),
			$prev = d.find('.' + e.classBtnPrev).click(function() {
				tabs[e.buttonsFunction + 'Prev'](val);
				return false
			}),
			$next = d.find('.' + e.classBtnNext).click(function() {
				tabs[e.buttonsFunction + 'Next'](val);
				return false
			}),
			$tab, $activeTab = [],
			$li, $lastElem, $view, $activeView, val = {},
			margin = 0;
		this.init = function() {
				if (e.orientation == 'horizontal') {
					$tabsInnerCont.css('overflow', 'hidden');
					val.func = 'outerWidth';
					val.obj = 'left';
					val.attr = 'marginLeft'
				} else {
					val.func = 'outerHeight';
					val.obj = 'top';
					val.attr = 'marginTop';
					val.prevBtnH = $prev.outerHeight();
					val.nextBtnH = $next.outerHeight(); (val.prevBtnH >= val.nextBtnH) ? val.buttonsH = val.prevBtnH : val.buttonsH = val.nextBtnH
				}
				if (e.totalWidth > 0) {
					g.width()
				}
				if (e.totalHeight > 0) {
					g.height()
				}
				tabs.init();
				if (e.autoplay == true) {
					autoplay.init()
				}
			};
		var g = {
				width: function() {
					var a = ($contentCont.outerWidth() - $contentCont.width());
					d.css('width', e.totalWidth + 'px');
					if (e.orientation == 'horizontal') {
						var b = ($tabsInnerCont.outerWidth() - $tabsInnerCont.width()),
							buttonsW = ($prev.outerWidth('true') + $next.outerWidth('true'));
						$tabsInnerCont.css('width', ((e.totalWidth - buttonsW) - b) + 'px');
						$contentCont.css('width', (e.totalWidth - a) + 'px')
					} else {
						$contentCont.css('width', ((e.totalWidth - f.outerWidth('true')) - a) + 'px')
					}
				},
				height: function() {
					var a = ($contentCont.outerHeight() - $contentCont.height());
					d.css('height', e.totalHeight + 'px');
					if (e.orientation == 'vertical') {
						var b = (f.outerHeight() - f.height());
						f.css('height', (e.totalHeight - b) + 'px');
						$contentCont.css('height', (e.totalHeight - a) + 'px')
					} else {
						$contentCont.css('height', (e.totalHeight - f.outerHeight()) + 'px')
					}
				}
			},
			tabs = {
				animated: '#' + d.attr('id') + ' .' + e.classTabsList + ':animated',
				init: function() {
					this.setSlideLength();
					this.posActive();
					this.bind()
				},
				setSlideLength: function() {
					if (e.tabsSlideLength == 0) {
						if (e.orientation == 'horizontal') {
							e.tabsSlideLength = $tabsInnerCont.outerWidth('true')
						} else {
							e.tabsSlideLength = (f.height() - val.buttonsH)
						}
					}
				},
				bind: function() {
					$tabs.delegate('li a.' + e.classTab, 'click', function() {
						tabs.click(this, true);
						return false
					});
					if ($.fn.mousewheel && e.tabsScroll == true) {
						$tabs.mousewheel(function(a, b) {
							(b > 0) ? tabs.slidePrev(val) : tabs.slideNext(val);
							return false
						})
					}
					$('a.' + e.classExtLink).each(function() {
						if ($(this).attr('rel') == d.attr('id')) {
							$(this).click(function() {
								$tab = tabs.findByRel($(this).attr('href').slice(1));
								tabs.click($tab);
								return false
							})
						}
					})
				},
				posActive: function() {
					this.getActive();
					content.showActive();
					$lastElem = $tabs.children('li:last');
					$tab = $activeTab;
					$activeTab = $activeTab.parent('li');
					if (($lastElem[val.func](true) + $lastElem.position()[val.obj]) > e.tabsSlideLength) {
						val.elemD = $activeTab[val.func](true);
						val.elemP = $activeTab.position()[val.obj];
						if (val.elemP > e.tabsSlideLength) {
							margin += (val.elemD + (val.elemP - e.tabsSlideLength));
							margin = (margin + e.offsetBR)
						} else if ((val.elemP + val.elemD) > e.tabsSlideLength) {
							margin += (val.elemD - (e.tabsSlideLength - val.elemP));
							margin = (margin + e.offsetBR)
						} else {
							margin = (margin - e.offsetTL)
						}
						$tabs.css(val.attr, -+margin);
						this.initButtons();
						this.showButtons()
					}
				},
				initButtons: function() {
					if (e.buttonsFunction == 'slide') {
						if ($tabs.children("li:first").position()[val.obj] == (0 + e.offsetTL)) {
							this.disableButton($prev)
						} else {
							this.enableButton($prev)
						}
						if (($lastElem.position()[val.obj] + $lastElem[val.func](true)) == (e.tabsSlideLength - e.offsetBR)) {
							this.disableButton($next)
						} else {
							this.enableButton($next)
						}
					} else {
						this.setButtonState()
					}
				},
				enableButton: function(a) {
					a.removeClass(e.classBtnDisabled)
				},
				disableButton: function(a) {
					a.addClass(e.classBtnDisabled)
				},
				showButtons: function() {
					$prev.show();
					$next.show()
				},
				click: function(a, b) {
					if ($(content.animated).length) {
						return false
					}
					$tab = $(a);
					if ($tab.hasClass(e.classTabActive)) {
						return false
					}
					$li = $tab.parent('li');
					this.setActive();
					if (e.autoplay == true) {
						if (e.autoplayClickStop == true && b == true) {
							e.autoplay = false;
							autoplay.clearInterval()
						} else {
							val.index = $tab.parent().index();
							autoplay.setInterval()
						}
					}
					val.elemP = $li.position();
					val.activeElemP = $activeTab.position();
					val.hash = this.getHash($tab);
					this.slideClicked(val);
					$activeView = $content.children('div.' + e.classViewActive).removeClass(e.classViewActive);
					$view = $content.children('div#' + val.hash).addClass(e.classViewActive);
					if (e.autoHeight == true) {
						content.adjustHeight()
					}
					if (e.contentAnim.length > 0) {
						content[e.contentAnim](val)
					} else {
						$activeView.hide();
						$view.show()
					}
				},
				clickPrev: function() {
					if ($(content.animated).length) {
						return false
					}
					val.$prevTab = this.find('prev');
					if (val.$prevTab.length) {
						this.click(val.$prevTab)
					}
				},
				clickNext: function() {
					if ($(content.animated).length) {
						return false
					}
					val.$nextTab = this.find('next');
					if (val.$nextTab.length) {
						this.click(val.$nextTab)
					}
				},
				find: function(a) {
					return $tab.parent()[a]().children('a.' + e.classTab)
				},
				findByRel: function(a) {
					return $tabs.find('[rel=' + a + ']')
				},
				getHash: function(a) {
					val.hash = a.attr('hash');
					if (val.hash) {
						return val.hash
					} else {
						return a.prop('hash')
					}
				},
				getActive: function() {
					if (e.urlLinking == true && location.hash) {
						$activeTab = this.findByRel(location.hash.slice(1))
					}
					if (!$activeTab.length) {
						if ($.cookie) {
							var a = $.cookie(d.attr('id'))
						}
						if (a) {
							this.removeActive();
							$activeTab = $a.eq(a).addClass(e.classTabActive)
						} else {
							$activeTab = $tabs.children('li').find('.' + e.classTabActive);
							if (!$activeTab.length) {
								$activeTab = $tabs.find('a:first').addClass(e.classTabActive)
								
							}
						}
					} else {
						this.removeActive();
						$activeTab.addClass(e.classTabActive)
					}
					this.saveActive($activeTab)
					
				},
				removeActive: function() {
					$tabs.children('li').find('.' + e.classTabActive).removeClass(e.classTabActive)
				},
				setActive: function() {
					
					$activeTab = $tabs.children('li').find('a.' + e.classTabActive).removeClass(e.classTabActive);
					$tab.addClass(e.classTabActive);
					this.saveActive($tab)
				},
				saveActive: function(a) {
					if (e.tabSaveState == true) {
						$.cookie(d.attr('id'), a.parent('li').index())
					}
				},
				slideClicked: function(a) {
					a.elemP = a.elemP[a.obj];
					a.elemD = $li[a.func](true);
					a.nextElemPos = ($li.next().length == 1) ? $li.next().position()[a.obj] : 0;
					if (a.elemP < (0 + e.offsetTL)) {
						a.elemHidden = (a.elemD - a.nextElemPos);
						margin = (margin - (a.elemHidden + e.offsetTL));
						this.enableButton($next)
					} else if ((a.elemD + a.elemP) > (e.tabsSlideLength - e.offsetBR)) {
						margin += (a.elemD - (e.tabsSlideLength - (a.elemP + e.offsetBR)));
						this.enableButton($prev)
					}
					this.animate();
					this.setButtonState()
				},
				slidePrev: function(a) {
					if ($(tabs.animated).length) {
						return false
					}
					$tabs.children('li').each(function() {
						$li = $(this);
						a.elemP = $li.position()[a.obj];
						if (a.elemP >= (0 + e.offsetTL)) {
							a.elemHidden = ($li.prev()[a.func](true) - a.elemP);
							margin = ((margin - a.elemHidden) - e.offsetTL);
							$li = $li.prev();
							tabs.animate();
							tabs.setButtonState($next);
							return false
						}
					})
				},
				slideNext: function(a) {
					if ($(tabs.animated).length) {
						return false
					}
					$tabs.children('li').each(function() {
						$li = $(this);
						a.elemD = $li[a.func](true);
						a.elemP = $li.position()[a.obj];
						if ((a.elemD + a.elemP) > (e.tabsSlideLength - e.offsetBR)) {
							a.elemHidden = (e.tabsSlideLength - a.elemP);
							margin += ((a.elemD - a.elemHidden) + e.offsetBR);
							tabs.animate();
							tabs.setButtonState($prev);
							return false
						}
					})
				},
				animate: function() {
					if (e.orientation == 'horizontal') {
						$tabs.animate({
							'marginLeft': -+margin
						}, e.tabsAnimTime, e.tabsEasing)
					} else {
						$tabs.animate({
							'marginTop': -+margin
						}, e.tabsAnimTime, e.tabsEasing)
					}
				},
				setButtonState: function(a) {
					if (e.buttonsFunction == 'click') {
						$li = $tab.parent('li')
					}
					if ($li.is(':first-child')) {
						this.disableButton($prev);
						this.enableButton($next)
					} else if ($li.is(':last-child')) {
						this.disableButton($next);
						this.enableButton($prev)
					} else {
						if (a) {
							this.enableButton(a)
						} else if (e.buttonsFunction == 'click') {
							this.enableButton($prev);
							this.enableButton($next)
						}
					}
				}
			},
			content = {
				
				animated: '#' + d.attr('id') + ' :animated',
				showActive: function() {
					$view = $content.children($activeTab.attr('href')).addClass(e.classViewActive);
					
					$content.children('div').css('position', 'absolute').not('div.' + e.classViewActive).hide();
					if (e.autoHeight == true) {
						$content.css('height', $view.height()).parent().css('height', 'auto')
					}
					
				},
				adjustHeight: function() {
					
					if (e.autoHeightTime > 0) {
						$content.animate({
							'height': $view.height()
						}, e.autoHeightTime)
					} else {
						$content.css('height', $view.height())
					}
				},
				fade: function() {
					$activeView.fadeOut(e.contentAnimTime);
					e.changeSlide();
					$view.fadeIn(e.contentAnimTime)
				},
				fadeOutIn: function() {
					$activeView.fadeOut(e.contentAnimTime, function() {
						e.changeSlide();
						$view.fadeIn(e.contentAnimTime)
					})
				},
				slideH: function(a) {
					a.wh = d.outerWidth(true);
					this.setSlideValues(a);
					$activeView.animate({
						'left': a.animVal
					}, e.contentAnimTime, e.contentEasing);
					e.changeSlide();
					$view.css({
						'display': 'block',
						'left': a.cssVal
					}).animate({
						'left': '0px'
					}, e.contentAnimTime, e.contentEasing, function() {
						$activeView.css('display', 'none');
					})
				},
				slideV: function(a) {
					a.wh = d.outerHeight(true);
					this.setSlideValues(a);
					$activeView.animate({
						'top': a.animVal
					}, e.contentAnimTime, e.contentEasing);
					e.changeSlide();
					$view.css({
						'display': 'block',
						'top': a.cssVal
					}).animate({
						'top': '0px'
					}, e.contentAnimTime, e.contentEasing, function() {
						$activeView.css('display', 'none')
					})
				},
				setSlideValues: function(a) {
					if (a.elemP > a.activeElemP[a.obj]) {
						a.animVal = -a.wh;
						a.cssVal = a.wh
					} else {
						a.animVal = a.wh;
						a.cssVal = -a.wh
					}
				}
			},
			autoplay = {
				init: function() {
					e.changeSlide();
					val.index = 0;
					this.setInterval()
				},
				setInterval: function() {
					this.clearInterval();
					val.intervalId = setInterval(function() {
						autoplay.play()
					}, e.autoplayInterval)
				},
				clearInterval: function() {
					clearInterval(val.intervalId)
				},
				play: function() {
					val.index++;
					if (val.index == $a.length) {
						val.index = 0
					}
					tabs.click($a[val.index])
				}
			},
			$optsBox = d.find('div.options_box'),
			$addBtn = d.find('ul.customize li a.add').click(function() {
				customize.addTab();
				return false
			}),
			$removeBtn = d.find('ul.customize li a.remove').click(function() {
				customize.removeTab();
				return false
			}),
			$optsBtn = d.find('ul.customize li a.options').click(function() {
				customize.toggleBox();
				return false
			}),
			$saveBtn = $optsBox.find('a.save_btn').click(function() {
				customize.saveOptions();
				return false
			}),
			length, totSize, customize = {
				addTab: function() {
					length = ($tabs.children('li').length + 1);
					if ($(tabs.animated).length || length == 31) {
						return false
					}
					if (length == 2) {
						$removeBtn.removeClass('btn_disabled').addClass('btn_enabled')
					}
					if (length == 30) {
						$addBtn.removeClass('btn_enabled').addClass('btn_disabled')
					}
					if (e.orientation == 'horizontal') {
						this.appendContent('st_content_', 'Horizontal Tab #', '')
					} else {
						this.appendContent('stv_content_', 'Vertical Tab #', '<span>Lorem ipsum dolor sit amet</span>')
					}
					this.showAppended();
					$tabs.find('li a:last').click(function() {
						tabs.click(this);
						return false
					});
					if (e.buttonsFunction == 'slide') {
						tabs.enableButton($prev);
						tabs.disableButton($next)
					} else {
						tabs.enableButton($next)
					}
					$content.children('div.st_tab_view:last').css({
						'position': 'absolute',
						'display': 'none'
					})
				},
				appendContent: function(a, b, c) {
					$tabs.append('<li><a href="#' + a + length + '" rel="tab_' + length + '" class="st_tab">' + b + length + c + '</a></li>');
					$content.append('<div id="' + a + length + '" class="st_tab_view"><h2>' + b + length + '</h2><div class="text">' + $content.children('#' + a + '1').find('div.text').html() + '</div></div>')
				},
				showAppended: function() {
					totSize = this.totLength();
					if (totSize > e.tabsSlideLength - e.offsetBR) {
						$prev.show();
						$next.show();
						margin = totSize - e.tabsSlideLength + e.offsetBR;
						this.animate()
					}
				},
				totLength: function() {
					totSize = 0;
					$tabs.children('li').each(function() {
						totSize += $(this)[val.func](true)
					});
					return totSize
				},
				animate: function() {
					if (e.orientation == 'horizontal') {
						$tabs.animate({
							'marginLeft': -+margin
						}, 300)
					} else {
						$tabs.animate({
							'marginTop': -+margin
						}, 300)
					}
				},
				removeTab: function() {
					length = $tabs.children('li').length;
					if ($(content.animated).length || length == 1) {
						return false
					}
					if (length == 30) {
						$addBtn.removeClass('btn_disabled').addClass('btn_enabled')
					}
					if (length == 2) {
						$removeBtn.removeClass('btn_enabled').addClass('btn_disabled')
					}
					$li = $tabs.children('li:last');
					if ($li.children('a').hasClass(e.classTabActive)) {
						var a = $li.prev().children('a'),
							tabLink = tabs.getHash(a);
						a.addClass(e.classTabActive);
						$content.children(tabLink).css({
								'top': '0px',
								'left': '0px',
								'display': 'block'
							}).addClass(e.classViewActive);
						$tab = $li.prev().children('a.' + e.classTab)
					}
					$li.remove();
					$content.children('div:last').remove();
					totSize = this.totLength();
					if (totSize > e.tabsSlideLength - e.offsetBR) {
						margin = totSize - e.tabsSlideLength + e.offsetBR;
						if (e.buttonsFunction == 'slide') {
							tabs.enableButton($prev);
							tabs.disableButton($next)
						} else {
							if ((length - 2) == $tab.parent('li').index()) {
								tabs.disableButton($next)
							}
						}
					} else {
						margin = 0;
						$prev.hide();
						$next.hide()
					}
					this.animate()
				},
				toggleBox: function() {
					$optsBox.toggleClass('show');
					$optsBtn.toggleClass('active')
				},
				saveOptions: function() {
					var c = d.parent('div').addClass('loading'),
						$tabDivs = d.children('div').not('div.customize_container');
					$tabDivs.fadeOut(200, function() {
							$tabDivs.css({
								'visibility': 'hidden',
								'display': 'block'
							});
							setTimeout(function() {
								$tabDivs.css({
									'visibility': 'visible',
									'display': 'none'
								}).fadeIn(200, function() {
									c.removeClass('loading')
								})
							}, 50);
							if ($optsBox.find('input#orientation').val() == 'horizontal') {
								e.buttonsFunction = $optsBox.find('input[name="buttons"]:checked').val();
								e.contentAnimTime = parseInt($optsBox.find('input[name="cont_dur"]:checked').val());
								e.tabsAlignment = $optsBox.find('input[name="tabs_align"]:checked').val();
								e.tabsAnimTime = parseInt($optsBox.find('input[name="tabs_dur"]:checked').val());
								e.tabsScroll = $optsBox.find('input[name="scroll"]:checked').val()
							} else {
								e.buttonsFunction = $optsBox.find('input[name="v_buttons"]:checked').val();
								e.contentAnimTime = parseInt($optsBox.find('input[name="v_cont_dur"]:checked').val());
								e.tabsAlignment = $optsBox.find('input[name="v_tabs_align"]:checked').val();
								e.tabsAnimTime = parseInt($optsBox.find('input[name="v_tabs_dur"]:checked').val());
								e.tabsScroll = $optsBox.find('input[name="v_scroll"]:checked').val()
							}
							e.contentAnim = $optsBox.find('select.cont_anim option:selected').val();
							e.contentEasing = $optsBox.find('select.cont_fx option:selected').val();
							e.tabsEasing = $optsBox.find('select.tab_fx option:selected').val();
							d[0].className = d[0].className.replace(/\balign.*?\b/g, '');
							d.addClass('align_' + e.tabsAlignment);
							if (e.buttonsFunction == 'click') {
								tabs.setButtonState()
							} else {
								$lastElem = $tabs.children('li:last');
								tabs.initButtons()
							}
							if (e.contentAnim == 'fadeOutIn') {
								e.contentAnimTime = (e.contentAnimTime - 100)
							}
							if (e.tabsScroll == 'true') {
								$tabs.mousewheel(function(a, b) {
									(b > 0) ? tabs.slidePrev(val) : tabs.slideNext(val);
									return false
								})
							} else {
								$tabs.unmousewheel()
							}
							$content.children('div').css('position', 'absolute');
							switch (e.contentAnim) {
							case 'slideH':
								$content.children('div:not(.' + e.classViewActive + ')').css('top', '0px');
								break;
							case 'slideV':
								$content.children('div:not(.' + e.classViewActive + ')').css('left', '0px');
								break;
							default:
								$content.children('div:not(.' + e.classViewActive + ')').css({
									'top': '0px',
									'left': '0px',
									'display': 'none'
								})
							}
						});
					$optsBox.removeClass('show');
					$optsBtn.removeClass('active')
				}
			}
	}
})(jQuery);