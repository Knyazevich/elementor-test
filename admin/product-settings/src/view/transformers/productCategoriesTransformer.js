const productCategoriesTransformer = (data) => {
  const transformedCategories = data.map((category) => ({
    label: category.name,
    value: category.id,
  }));

  return [{ value: 0, label: 'Select category' }, ...transformedCategories];
};

export default productCategoriesTransformer;
