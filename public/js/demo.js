/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */
(function ($)
{
  'use strict'

  var $sidebar = $('.control-sidebar')
  var $container = $('<div />', {
    class: 'p-3 control-sidebar-content'
  })

  $sidebar.append($container)

  $container.append(
    '<h5>Customize Panel</h5><hr class="mb-2"/>'
  )

  // var $no_border_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('.main-header').hasClass('border-bottom-0'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('.main-header').addClass('border-bottom-0')
  //   } else
  //   {
  //     $('.main-header').removeClass('border-bottom-0')
  //   }
  // })
  // var $no_border_container = $('<div />', { 'class': 'mb-1' }).append($no_border_checkbox).append('<span>No Navbar border</span>')
  // $container.append($no_border_container)

  // var $text_sm_body_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('body').hasClass('text-sm'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('body').addClass('text-sm')
  //   } else
  //   {
  //     $('body').removeClass('text-sm')
  //   }
  // })
  // var $text_sm_body_container = $('<div />', { 'class': 'mb-1' }).append($text_sm_body_checkbox).append('<span>Body small text</span>')
  // $container.append($text_sm_body_container)

  // var $text_sm_header_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('.main-header').hasClass('text-sm'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('.main-header').addClass('text-sm')
  //   } else
  //   {
  //     $('.main-header').removeClass('text-sm')
  //   }
  // })
  // var $text_sm_header_container = $('<div />', { 'class': 'mb-1' }).append($text_sm_header_checkbox).append('<span>Navbar small text</span>')
  // $container.append($text_sm_header_container)

  // var $text_sm_sidebar_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('.nav-sidebar').hasClass('text-sm'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('.nav-sidebar').addClass('text-sm')
  //   } else
  //   {
  //     $('.nav-sidebar').removeClass('text-sm')
  //   }
  // })
  // var $text_sm_sidebar_container = $('<div />', { 'class': 'mb-1' }).append($text_sm_sidebar_checkbox).append('<span>Sidebar nav small text</span>')
  // $container.append($text_sm_sidebar_container)

  // var $text_sm_footer_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('.main-footer').hasClass('text-sm'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('.main-footer').addClass('text-sm')
  //   } else
  //   {
  //     $('.main-footer').removeClass('text-sm')
  //   }
  // })
  // var $text_sm_footer_container = $('<div />', { 'class': 'mb-1' }).append($text_sm_footer_checkbox).append('<span>Footer small text</span>')
  // $container.append($text_sm_footer_container)

  // var $flat_sidebar_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('.nav-sidebar').hasClass('nav-flat'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('.nav-sidebar').addClass('nav-flat')
  //   } else
  //   {
  //     $('.nav-sidebar').removeClass('nav-flat')
  //   }
  // })
  // var $flat_sidebar_container = $('<div />', { 'class': 'mb-1' }).append($flat_sidebar_checkbox).append('<span>Sidebar nav flat style</span>')
  // $container.append($flat_sidebar_container)

  // var $legacy_sidebar_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('.nav-sidebar').hasClass('nav-legacy'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('.nav-sidebar').addClass('nav-legacy')
  //   } else
  //   {
  //     $('.nav-sidebar').removeClass('nav-legacy')
  //   }
  // })
  // var $legacy_sidebar_container = $('<div />', { 'class': 'mb-1' }).append($legacy_sidebar_checkbox).append('<span>Sidebar nav legacy style</span>')
  // $container.append($legacy_sidebar_container)

  // var $compact_sidebar_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('.nav-sidebar').hasClass('nav-compact'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('.nav-sidebar').addClass('nav-compact')
  //   } else
  //   {
  //     $('.nav-sidebar').removeClass('nav-compact')
  //   }
  // })
  // var $compact_sidebar_container = $('<div />', { 'class': 'mb-1' }).append($compact_sidebar_checkbox).append('<span>Sidebar nav compact</span>')
  // $container.append($compact_sidebar_container)

  // var $child_indent_sidebar_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('.nav-sidebar').hasClass('nav-child-indent'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('.nav-sidebar').addClass('nav-child-indent')
  //   } else
  //   {
  //     $('.nav-sidebar').removeClass('nav-child-indent')
  //   }
  // })
  // var $child_indent_sidebar_container = $('<div />', { 'class': 'mb-1' }).append($child_indent_sidebar_checkbox).append('<span>Sidebar nav child indent</span>')
  // $container.append($child_indent_sidebar_container)

  // var $no_expand_sidebar_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('.main-sidebar').hasClass('sidebar-no-expand'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('.main-sidebar').addClass('sidebar-no-expand')
  //   } else
  //   {
  //     $('.main-sidebar').removeClass('sidebar-no-expand')
  //   }
  // })
  // var $no_expand_sidebar_container = $('<div />', { 'class': 'mb-1' }).append($no_expand_sidebar_checkbox).append('<span>Main Sidebar disable hover/focus auto expand</span>')
  // $container.append($no_expand_sidebar_container)

  // var $text_sm_brand_checkbox = $('<input />', {
  //   type: 'checkbox',
  //   value: 1,
  //   checked: $('.brand-link').hasClass('text-sm'),
  //   'class': 'mr-1'
  // }).on('click', function ()
  // {
  //   if ($(this).is(':checked'))
  //   {
  //     $('.brand-link').addClass('text-sm')
  //   } else
  //   {
  //     $('.brand-link').removeClass('text-sm')
  //   }
  // })
  // var $text_sm_brand_container = $('<div />', { 'class': 'mb-4' }).append($text_sm_brand_checkbox).append('<span>Brand small text</span>')
  // $container.append($text_sm_brand_container)

  var navbar_dark_skins = [
    'navbar-primary',
    'navbar-secondary',
    'navbar-info',
    'navbar-success',
    'navbar-danger',
    'navbar-indigo',
    'navbar-purple',
    'navbar-pink',
    'navbar-navy',
    'navbar-lightblue',
    'navbar-teal',
    'navbar-cyan',
    'navbar-dark',
    'navbar-gray-dark',
    'navbar-gray',
  ]

  var navbar_light_skins = [
    'navbar-light',
    'navbar-warning',
    'navbar-white',
    'navbar-orange',
  ]

  var sidebar_colors = [
    'bg-primary',
    'bg-warning',
    'bg-info',
    'bg-danger',
    'bg-success',
    'bg-indigo',
    'bg-lightblue',
    'bg-navy',
    'bg-purple',
    'bg-fuchsia',
    'bg-pink',
    'bg-maroon',
    'bg-orange',
    'bg-lime',
    'bg-teal',
    'bg-olive'
  ]

  var accent_colors = [
    'accent-primary',
    'accent-warning',
    'accent-info',
    'accent-danger',
    'accent-success',
    'accent-indigo',
    'accent-lightblue',
    'accent-navy',
    'accent-purple',
    'accent-fuchsia',
    'accent-pink',
    'accent-maroon',
    'accent-orange',
    'accent-lime',
    'accent-teal',
    'accent-olive'
  ]

  var sidebar_skins = [
    'sidebar-dark-primary',
    'sidebar-dark-warning',
    'sidebar-dark-info',
    'sidebar-dark-danger',
    'sidebar-dark-success',
    'sidebar-dark-indigo',
    'sidebar-dark-lightblue',
    'sidebar-dark-navy',
    'sidebar-dark-purple',
    'sidebar-dark-fuchsia',
    'sidebar-dark-pink',
    'sidebar-dark-maroon',
    'sidebar-dark-orange',
    'sidebar-dark-lime',
    'sidebar-dark-teal',
    'sidebar-dark-olive',
    'sidebar-light-primary',
    'sidebar-light-warning',
    'sidebar-light-info',
    'sidebar-light-danger',
    'sidebar-light-success',
    'sidebar-light-indigo',
    'sidebar-light-lightblue',
    'sidebar-light-navy',
    'sidebar-light-purple',
    'sidebar-light-fuchsia',
    'sidebar-light-pink',
    'sidebar-light-maroon',
    'sidebar-light-orange',
    'sidebar-light-lime',
    'sidebar-light-teal',
    'sidebar-light-olive'
  ]

  $container.append('<h6>Navbar Variants</h6>')
  var $navbar_variants = $('<div />', {
    'class': 'd-flex'
  })
  var navbar_all_colors = navbar_dark_skins.concat(navbar_light_skins)
  var ada_header = false;
  navbar_all_colors.map(function (color)
  {
    var cookie = getCookie(".main-header." + color);
    if (cookie == null) cookie = '';
    if (cookie != "")
    {
      ada_header = true;
      $('.main-header').addClass(color);
    }
  })
  if (!ada_header) $('.main-header').addClass('navbar-white');

  if (getCookie(".main-header.navbar-dark") != "")
  {
    $('.main-header').addClass('navbar-dark');
  }
  else
  {
    $('.main-header').addClass('navbar-light');
  }

  if (getCookie(".main-header.navbar-light") != "") $('.main-header').addClass('navbar-light');
  var ada_sidebar = false;
  sidebar_skins.map(function (skin)
  {
    var cookie = getCookie(".main-sidebar." + skin);
    if (cookie == null) cookie = '';
    if (cookie != "")
    {
      ada_sidebar = true;
      $('.main-sidebar').addClass(skin);
    }
  })
  if (!ada_sidebar) $('.main-sidebar').addClass('sidebar-light-primary');

  var $navbar_variants_colors = createSkinBlock(navbar_all_colors, function (e)
  {
    var color = $(this).data('color')
    var $main_header = $('.main-header')
    $main_header.removeClass('navbar-dark').removeClass('navbar-light')
    deleteCookie('.main-header.navbar-dark');
    deleteCookie('.main-header.navbar-light');
    navbar_all_colors.map(function (color)
    {
      deleteCookie('.main-header.' + color);
      $main_header.removeClass(color)
    })

    if (navbar_dark_skins.indexOf(color) > -1)
    {
      setCookie('.main-header.navbar-dark', "true")
      $main_header.addClass('navbar-dark')
    } else
    {
      setCookie('.main-header.navbar-light', "true")
      $main_header.addClass('navbar-light')
    }

    setCookie('.main-header.' + color, "true")
    $main_header.addClass(color)
  })
  $navbar_variants.append($navbar_variants_colors)
  $container.append($navbar_variants)

  var logo_skins = navbar_all_colors
  var ada_brand = false;
  logo_skins.map(function (skin)
  {
    var cookie = getCookie(".brand-link." + skin);
    if (cookie == null) cookie = '';
    if (cookie != "")
    {
      ada_brand = true
      $('.brand-link').addClass(skin);
    }
  })
  if (!ada_brand) $('.brand-link').addClass('navbar-white');

  $container.append('<h6>Brand Logo Variants</h6>')
  var $logo_variants = $('<div />', {
    'class': 'd-flex'
  })
  $container.append($logo_variants)
  var $clear_btn = $('<a />', {
    href: 'javascript:void(0)'
  }).text('clear').on('click', function ()
  {
    var $logo = $('.brand-link')
    logo_skins.map(function (skin)
    {
      deleteCookie('.brand-link.' + skin);
      $logo.removeClass(skin)
    })
  })
  $container.append(createSkinBlock(logo_skins, function ()
  {
    var color = $(this).data('color')
    var $logo = $('.brand-link')
    logo_skins.map(function (skin)
    {
      deleteCookie('.brand-link.' + skin);
      $logo.removeClass(skin)
    })
    setCookie('.brand-link.' + color, "true")
    $logo.addClass(color)
  }).append($clear_btn))

  $container.append('<h6>Dark Sidebar Variants</h6>')
  var $sidebar_variants_dark = $('<div />', {
    'class': 'd-flex'
  })
  $container.append($sidebar_variants_dark)
  $container.append(createSkinBlock(sidebar_colors, function ()
  {
    var color = $(this).data('color')
    var sidebar_class = 'sidebar-dark-' + color.replace('bg-', '')
    var $sidebar = $('.main-sidebar')
    sidebar_skins.map(function (skin)
    {
      deleteCookie('.main-sidebar.' + skin);
      $sidebar.removeClass(skin)
    })

    setCookie('.main-sidebar.' + sidebar_class);
    $sidebar.addClass(sidebar_class)
  }))

  $container.append('<h6>Light Sidebar Variants</h6>')
  var $sidebar_variants_light = $('<div />', {
    'class': 'd-flex'
  })
  $container.append($sidebar_variants_light)
  $container.append(createSkinBlock(sidebar_colors, function ()
  {
    var color = $(this).data('color')
    var sidebar_class = 'sidebar-light-' + color.replace('bg-', '')
    var $sidebar = $('.main-sidebar')
    sidebar_skins.map(function (skin)
    {
      deleteCookie('.main-sidebar.' + skin);
      $sidebar.removeClass(skin)
    })

    setCookie('.main-sidebar.' + sidebar_class);
    $sidebar.addClass(sidebar_class)
  }))

  var ada_accent = false;
  accent_colors.map(function (skin)
  {
    var cookie = getCookie("body." + skin);
    if (cookie == null) cookie = '';
    if (cookie != "")
    {
      ada_accent = true;
      $('body').addClass(skin);
    }
  })
  if (!ada_accent) $('body').addClass('accent-primary')
  $container.append('<h6>Accent Color Variants</h6>')
  var $accent_variants = $('<div />', {
    'class': 'd-flex'
  })
  $container.append($accent_variants)
  $container.append(createSkinBlock(accent_colors, function ()
  {
    var color = $(this).data('color')
    var accent_class = color
    var $body = $('body')
    accent_colors.map(function (skin)
    {
      deleteCookie('body.' + skin);
      $body.removeClass(skin)
    })

    setCookie('body.' + accent_class, "true");
    $body.addClass(accent_class)
  }))



  function createSkinBlock(colors, callback)
  {
    var $block = $('<div />', {
      'class': 'd-flex flex-wrap mb-3'
    })

    colors.map(function (color)
    {
      var $color = $('<div />', {
        'class': (typeof color === 'object' ? color.join(' ') : color).replace('navbar-', 'bg-').replace('accent-', 'bg-') + ' elevation-2'
      })

      $block.append($color)

      $color.data('color', color)

      $color.css({
        width: '40px',
        height: '20px',
        borderRadius: '25px',
        marginRight: 10,
        marginBottom: 10,
        opacity: 0.8,
        cursor: 'pointer'
      })

      $color.hover(function ()
      {
        $(this).css({ opacity: 1 }).removeClass('elevation-2').addClass('elevation-4')
      }, function ()
      {
        $(this).css({ opacity: 0.8 }).removeClass('elevation-4').addClass('elevation-2')
      })

      if (callback)
      {
        $color.on('click', callback)
      }
    })

    return $block
  }


  $('.product-image-thumb').on('click', function ()
  {
    const image_element = $(this).find('img');
    $('.product-image').prop('src', $(image_element).attr('src'))
    $('.product-image-thumb.active').removeClass('active');
    $(this).addClass('active');
  });
})(jQuery)
