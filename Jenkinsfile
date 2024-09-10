pipeline {
    agent any
    stages {
        stage("Verify tooling") {
            steps {
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    sh '''
                        docker info
                        docker version
                        docker compose version
                    '''
                }
            }
        }
        // stage("Verify SSH connection to server") {
        //     steps {
        //         sshagent(credentials: ['aws-ec2']) {
        //             sh '''
        //                 ssh -o StrictHostKeyChecking=no ec2-user@13.40.116.143 whoami
        //             '''
        //         }
        //     }
        // }
        stage("Clear all running docker containers") {
            steps {
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    script {
                        try {
                            sh 'docker rm -f $(docker ps -a -q)'
                        } catch (Exception e) {
                            echo 'No running container to clear up...'
                        }
                    }
                }
            }
        }
        stage("Start Docker") {
            steps {
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    sh 'make up'
                    sh 'docker compose ps'
                }
            }
        }
        stage("Populate .env file") {
            steps {
                script {
                    sh 'cp .env.example .env'
                }
            }
        }
        stage("Populate vendor folder") {
            steps {
                script {
                    def folderExists = sh(script: 'test -d vendor && echo "true" || echo "false"', returnStdout: true).trim()
                    if (folderExists == "false") {
                        sh 'composer install'
                    }
                }
            }
        }
        stage("Generate APP_KEY") {
            steps {
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    sh 'php artisan key:generate'
                }
            }
        }
        stage("Run Tests") {
            steps {
                catchError(buildResult: 'SUCCESS', stageResult: 'FAILURE') {
                    sh 'php artisan test'
                }
            }
        }
    }

    post {
        always {
            echo 'Cleaning up...'
            sh 'docker ps'
        }
    }
}
