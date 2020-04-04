AoS CustomerView for Magento 2
======


## Description

This feature for Magento 2 adds additional buttons in admin panel product and category view.

Button leads to frontend product or category page.
Allows user after save to see product/category while being configured.

Button is disabled when product is not salable.

Saves time for administrators while working with catalog containing several products. Administrator can quickly see product in frontend without searching or creating URL manually.

Works with multiple store views. After store view change button includes URL from particular store.
 

##  Testing scenarios

### Products

- Go to admin panel
- Go to CATALOG -> Products
- Edit product
- On edit product page new button is visible [Customer View] Button is between [Add Attribute] button and [Save] button
- After clicking product is being opened in new tab
- If product is out of stock or just not salable button is disabled

### Categories

- Go to admin panel
- Go to CATALOG -> Categories
- Choose category from tree which can be visible in frontend
- New button is visible [Customer View] Button is between [Delete] button and [Save] button
- After clicking product is being opened in new tab

## V1.0.0

###### Improvements

- Product button which shows product page without looking for valid URL. You can just use URL from button to see how product page looks like.
- Handles all product URL placed in rewrite table
- Category button which shows category page without looking for valid URL. You can just use URL from button to see how category page looks like.
- Works also with store code in URL mode
- Shows proper URLs after changing store view
- Button is Split type button which contains dropdown menu. Different ULRs are visible after clicking down arrow.
