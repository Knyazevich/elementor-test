export const THEME_PATH_NAMESPACE = '/twenty-twenty-child/v1';
export const WP_PATH_NAMESPACE = '/wp/v2';
export const FULL_WP_PATH = '/wp-json/wp/v2';

export const isJSON = (string) => {
  try {
    JSON.parse(string);
  } catch (e) {
    return false;
  }

  return true;
};
