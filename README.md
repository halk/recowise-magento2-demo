[![GitHub license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://github.com/halk/recowise-magento2-demo/blob/master/LICENSE)

# Magento2 demo for RecoWise

RecoWise is an integration framework for recommendation engines. This project provides a demo for the aforementioned framework on the basis of [Magento2](https://github.com/magento/magento2).

This is part of my [MSc project](https://github.com/halk/msc-project-report) work. Since the MSc project is still ongoing, a proper README will be submitted by October.

See [recowise-vagrant](https://github.com/halk/recowise-vagrant) for more details.

## Demo Features

1. "Products other customers - who viewed the same things as you - viewed but you did not" on the homepage (in-common collaborative recommender)
2. "Products other customers - who wishlisted the same things as you - wishlisted but you did not" on My Wishlists (in-common collaborative recommender)
3. Weighted combination of 1 and 2 on My Account (weighted hybrid recommender)
4. "Similar products to what you have in your basket" on My Basket (item-similarity content-based recommender)
5. Manage attributes which are exported to the RecoWise
6. Shell script to run a full catalog export to RecoWise
