# Contributing Guide

When adding any cards to the repository please follow these basic pointers:

1. Ensure that your build is passing on our [build agent](https://travis-ci.org/Alsciende/fiveringsdb-data). When you create your PR it will fail if the data validation does not pass.
2. Check that the card you are adding has not already been added. Sometimes there can be typos in the name and it's best to check the PackCard JSON file for your pack/card combinations since it's quicker then looking through the whole Card directory.
3. Make sure that Political and Millitary scores are strings.
4. When adding a card with the same title from another clan please use the Name Extra field to distinguish between the two. Note that the slug must match the Name and Name Extra field combined.
5. Please ensure the card filename matches the card slug. If not you will get a validation error.