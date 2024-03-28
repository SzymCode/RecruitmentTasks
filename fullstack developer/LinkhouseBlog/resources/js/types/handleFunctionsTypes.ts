import { AxiosResponse } from 'axios'
import { ArticleInterface } from './'

export type GetAllArticlesAxiosFunctionType = AxiosResponse<ArticleInterface[]>
export type GetAllArticlesFunctionType = Promise<ArticleInterface[]>
