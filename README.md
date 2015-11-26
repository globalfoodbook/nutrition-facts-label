# Nutrition Facts Label
Contributors: (kengimel)
Tags: food, nutrition, nutrition facts, nutrition label, food-cook, recipe plugin, shortcode, global food book
Requires at least: 3.0.1
Tested up to: 4.2.2
Stable tag: 1
License: MIT License
License URI: http://opensource.org/licenses/MIT

This plugin provides food bloggers the ability to add nutrition facts label to their recipe post, with nutritive insights, short-codes and general update facility.

## Description
This plugin provides food bloggers the ability to add nutrition facts label to their recipe post, with nutritive insights, short-codes and general update facility.

This plugin we have derived from our code based on  [www.globalfoodbook.com](http://www.globalfoodbook.com). It part of our drive to contribute back to the awesome wordpress community.

This plugin will work best on blogs that use food-cook or woo themes.

We strongly advise using this plugin under guidance of your developer.

Our motivation for releasing this plugin based on a forum discussion on the food-cook theme site, felt we already had some code that could serve as a basis for other to benefit and possibly improve on.

It is possible to create custom a post type called recipe and also this would work, but we strongly advise to this with the guidance of a wordpress developer.

In order to generate the plugin, you can either generate an image or generate a post_meta key that holds a json data that could be use to generate the nutrition label.

This plugin also includes a meta box within the recipe post page in the admin area.

In order to automatically show the recipe label on the every recipe.

Your developer should add this line of code to best possible place.

```
  <?php echo do_shortcode( '[embed_nutrition_label]' ) ?>
```

It is also possible to embed this as a as a shortcode from the text editor.


```
[embed_nutrition_label]
```
### How to Use this Nutrition Label?
Login into your Wordpress account.
Scroll down to the "Ingredients Section" and list the Ingredients.
Press "Generate Label" on the Nutrition Facts Label Generator.
The nutrition facts are automatically generated for you.
N:B List the ingredients individually including the quantities.

### How to Include Nutrition Label on Existing Recipes?
To include nutrition label on existing food recipes, simply press the "Go" button for automatic generation of the nutrition label.
For the unsuccessful updates, make sure that the ingredients are placed line by line and in each line they are without commas or fullstops.
Afterwards, press the "Go" button.


## Installation

1. Upload /mailchimp-woothemes-subscribe to the /wp-content/plugins directory
2. Activate the plugin through the Plugins menu in WordPress

## Frequently Asked Questions

### How do I use this Nutrition Label ?
Login into your Wordpress account.
Scroll down to the "Ingredients Section" and list the Ingredients.
Press "Generate Label" on the Nutrition Facts Label Generator.
The nutrition facts are automatically generated for you.
N:B List the ingredients individually including the quantities.

### How to Include Nutrition Label on Existing Recipes
To include nutrition label on existing food recipes, simply press the "Go" button for automatic generation of the nutrition label.
For the unsuccessful updates, make sure that the ingredients are placed line by line and in each line they are without commas or fullstops.
Afterwards, press the "Go" button.

## Screenshots

1. Generate Nutrition Facts Label
2. Update existing recipes.
3. Sample on the recipe page.

## Changelog

### 1.0
* Initial Release

## Upgrade Notice

### 1
* Initial Release

## Notes to developers

#### Contributing

If you would like to contribute to our suite of plugins, head on over to [Global Food Book Labs](https://github.com/globalfoodbook). Feel free to fork and contribute back.

1. Fork it (https://github.com/globalfoodbook/mailchimp-foodcook-subscribe)
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create a new Pull Request

#### Adding Screenshots to the wordpress repo

1. Rename each screenshot for each step like this. For step 1 the screenshot is screenshot-1.png.
2. The banner image is named as banner-772x250.png.
3. Use an SVN client like smart svn or rapid svn etc to uploads these iamges to the /assets folder.
4. After this commit and all will be picked up.

#### Pushing plugin to wordpress svn repo

1. Clone this repo

          `git clone git@github.com:globalfoodbook/mailchimp-foodcook-subscribe.git`

2. cd path/to/mailchimp-foodcook-subscribe
3. vim .git/config
4. Add the code below:

          [svn-remote "svn"]
                  url = http://plugins.svn.wordpress.org/[plugin_name]/trunk
                  fetch = :refs/remotes/git-svn

5. Then merge the master into the new branch:

          `git svn fetch svn`
          `git checkout -b svn git-svn`
          `git merge master`
          `git svn dcommit --username [wordpress.org username]`

6. Then rebase that branch to the master, and you can dcommit from the master to svn

          `git checkout master`
          `git rebase svn`
          `git branch -d svn`
          `git svn dcommit --username [wordpress.org username]`
