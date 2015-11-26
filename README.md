# Nutrition Facts Label
Contributors: (kengimel)
Tags: food, nutrition, nutrition facts, nutrition label, food-cook, recipe plugin, shortcode, global food book
Requires at least: 3.0.1
Tested up to: 4.2.2
Stable tag: 1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin provides food bloggers the ability to add nutrition facts label to their recipe post(s), with nutritive insights, short-codes and general update facility.

## Description
This plugin provides food bloggers the ability to add nutrition facts label to their recipe post(s), with nutritive insights, short-codes and general update facility.

This plugin has been derived from our code used on  [www.globalfoodbook.com](http://www.globalfoodbook.com). It is part of our drive to contribute back to the awesome Wordpress community.

This plugin will work best on blogs that use food-cook or woo themes.

We strongly advise using it under guidance of a Wordpress developer.

Our motivation for releasing this plugin is based on a forum discussion on the food-cook theme site and we felt that we already had some code that could serve as a basis for others to benefit and possibly improve on.

It is possible to create a custom post type called "recipe" and ingredients post_meta entry with key "RECIPE_META_ingredients". We strongly advise that you do this under the guidance of a Wordpress developer.

In order to generate the plugin, you can either generate an image or generate a post_meta key that holds a JSON data which could be used to generate the nutrition label.

The plugin also includes a meta box within the recipe post page in the admin area.

In order to automatically show the recipe label on the every recipe, your Wordpress developer should add this line of code to the best possible place.

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
For any unsuccessful updates, make sure that the ingredients are placed line by line and in each line they are without commas or fullstops.
Then press the "Go" button to generate label.


## Installation

1. Upload /nutrition-facts-label to the /wp-content/plugins directory
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
Then press the "Go" button.

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

1. Fork it (https://github.com/globalfoodbook/nutrition-facts-label)
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create a new Pull Request

#### Adding Screenshots to the Wordpress repo

1. Rename each screenshot for each step like this. For step 1 the screenshot is screenshot-1.png.
2. The banner image is named as banner-772x250.png.
3. Use an SVN client like smart svn or rapid svn etc to upload these images to the /assets folder.
4. After this, commit and all will be picked up.

#### Pushing plugin to Wordpress svn repo

1. Clone this repo

          `git clone git@github.com:globalfoodbook/nutrition-facts-label.git`

2. cd path/to/nutrition-facts-label
3. vim .git/config
4. Add the code below:

          [svn-remote "svn"]
                  url = http://plugins.svn.wordpress.org/[plugin_name]/trunk
                  fetch = :refs/remotes/git-svn

5. Then merge the master into the new branch:

          `git svn fetch svn`
          `git checkout -b svn git-svn`
          `git merge master`
          `git svn dcommit --username [Wordpress.org username]`

6. Then rebase that branch to the master, and you can dcommit from the master to svn

          `git checkout master`
          `git rebase svn`
          `git branch -d svn`
          `git svn dcommit --username [Wordpress.org username]`
